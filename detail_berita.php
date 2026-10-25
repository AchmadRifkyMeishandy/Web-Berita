<?php
require_once __DIR__ . '/controllers/connect.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function h($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$rawId = $_GET['id_berita'] ?? null;
$validatedId = filter_var($rawId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$idBerita = ($validatedId === false || $validatedId === null) ? 0 : (int) $validatedId;
$kodeBerita = (string) $idBerita;
$article = null;
$errors = [];

if ($idBerita > 0) {
    $articleStatement = mysqli_prepare(
        $db,
        "SELECT b.id_berita, b.judul_berita, b.isi_berita, b.tanggal_berita,
                b.gambar_berita, k.nama_kategori
         FROM berita AS b
         LEFT JOIN kategori AS k ON k.id_kategori = b.kode_kategori
         WHERE b.id_berita = ?
         LIMIT 1"
    );
    if ($articleStatement) {
        mysqli_stmt_bind_param($articleStatement, 'i', $idBerita);
        mysqli_stmt_execute($articleStatement);
        $articleResult = mysqli_stmt_get_result($articleStatement);
        $article = $articleResult ? mysqli_fetch_assoc($articleResult) : null;
        mysqli_stmt_close($articleStatement);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $article) {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($_SESSION['csrf_token'], $postedToken)) {
        $errors[] = 'Sesi formulir sudah tidak berlaku. Muat ulang halaman lalu coba lagi.';
    } else {
        $nameInput = $_POST['nama_k'] ?? '';
        $bodyInput = $_POST['isi_k'] ?? '';
        $name = is_string($nameInput) ? trim($nameInput) : '';
        $body = is_string($bodyInput) ? trim($bodyInput) : '';
        $nameLength = function_exists('mb_strlen') ? mb_strlen($name, 'UTF-8') : strlen($name);
        $bodyLength = function_exists('mb_strlen') ? mb_strlen($body, 'UTF-8') : strlen($body);

        if ($name === '' || $body === '') {
            $errors[] = 'Nama dan isi komentar wajib diisi.';
        } elseif ($nameLength > 255) {
            $errors[] = 'Nama maksimal 255 karakter.';
        } elseif ($bodyLength > 10000) {
            $errors[] = 'Komentar maksimal 10.000 karakter.';
        } elseif (isset($_POST['tbh'])) {
            $tanggal = date('d F Y');
            $insertStatement = mysqli_prepare(
                $db,
                "INSERT INTO komentar (nama_k, isi_k, tanggal_k, kode_berita)
                 VALUES (?, ?, ?, ?)"
            );
            if ($insertStatement) {
                mysqli_stmt_bind_param($insertStatement, 'ssss', $name, $body, $tanggal, $kodeBerita);
                $saved = mysqli_stmt_execute($insertStatement);
                mysqli_stmt_close($insertStatement);
                if ($saved) {
                    header('Location: detail_berita.php?id_berita=' . $idBerita . '#comments');
                    exit;
                }
            }
            $errors[] = 'Komentar belum dapat disimpan. Silakan coba lagi.';
        } elseif (isset($_POST['bls'])) {
            $rawCommentId = $_POST['kode_k'] ?? null;
            $validatedCommentId = filter_var($rawCommentId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if ($validatedCommentId === false || $validatedCommentId === null) {
                $errors[] = 'Komentar yang ingin dibalas tidak valid.';
            } else {
                $commentId = (int) $validatedCommentId;
                $parentStatement = mysqli_prepare(
                    $db,
                    "SELECT id_k FROM komentar WHERE id_k = ? AND kode_berita = ? LIMIT 1"
                );
                $parentExists = false;
                if ($parentStatement) {
                    mysqli_stmt_bind_param($parentStatement, 'is', $commentId, $kodeBerita);
                    mysqli_stmt_execute($parentStatement);
                    $parentResult = mysqli_stmt_get_result($parentStatement);
                    $parentExists = $parentResult && mysqli_fetch_assoc($parentResult) !== null;
                    mysqli_stmt_close($parentStatement);
                }

                if (!$parentExists) {
                    $errors[] = 'Komentar yang ingin dibalas tidak ditemukan.';
                } else {
                    $kodeKomentar = (string) $commentId;
                    $tanggalBalasan = date('d F Y');
                    $replyStatement = mysqli_prepare(
                        $db,
                        "INSERT INTO balaskomentar (nama_bk, isi_bk, tanggal_bk, kode_k, kode_berita)
                         VALUES (?, ?, ?, ?, ?)"
                    );
                    if ($replyStatement) {
                        mysqli_stmt_bind_param(
                            $replyStatement,
                            'sssss',
                            $name,
                            $body,
                            $tanggalBalasan,
                            $kodeKomentar,
                            $kodeBerita
                        );
                        $saved = mysqli_stmt_execute($replyStatement);
                        mysqli_stmt_close($replyStatement);
                        if ($saved) {
                            header('Location: detail_berita.php?id_berita=' . $idBerita . '#comments');
                            exit;
                        }
                    }
                    $errors[] = 'Balasan belum dapat disimpan. Silakan coba lagi.';
                }
            }
        }
    }
}

$comments = [];
$repliesByComment = [];
if ($article) {
    $commentStatement = mysqli_prepare(
        $db,
        "SELECT id_k, nama_k, isi_k, tanggal_k
         FROM komentar
         WHERE kode_berita = ?
         ORDER BY id_k DESC"
    );
    if ($commentStatement) {
        mysqli_stmt_bind_param($commentStatement, 's', $kodeBerita);
        mysqli_stmt_execute($commentStatement);
        $commentResult = mysqli_stmt_get_result($commentStatement);
        if ($commentResult) {
            while ($row = mysqli_fetch_assoc($commentResult)) {
                $comments[] = $row;
            }
        }
        mysqli_stmt_close($commentStatement);
    }

    $replyStatement = mysqli_prepare(
        $db,
        "SELECT id_bk, nama_bk, isi_bk, tanggal_bk, kode_k
         FROM balaskomentar
         WHERE kode_berita = ?
         ORDER BY id_bk ASC"
    );
    if ($replyStatement) {
        mysqli_stmt_bind_param($replyStatement, 's', $kodeBerita);
        mysqli_stmt_execute($replyStatement);
        $replyResult = mysqli_stmt_get_result($replyStatement);
        if ($replyResult) {
            while ($row = mysqli_fetch_assoc($replyResult)) {
                $repliesByComment[(string) $row['kode_k']][] = $row;
            }
        }
        mysqli_stmt_close($replyStatement);
    }
}
if (!$article) {
    http_response_code(404);
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $article ? h($article['judul_berita']) . ' — Berita Indonesia' : 'Berita tidak ditemukan — Berita Indonesia'; ?></title>
    <?php include __DIR__ . '/link.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main class="news-article">
    <a class="news-article__back" href="index.php"><i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali ke beranda</a>

    <?php if (!$article): ?>
        <div class="news-empty">
            <h1>Berita tidak ditemukan</h1>
            <p>Tautan yang kamu buka tidak cocok dengan artikel yang tersedia.</p>
            <a class="news-read-link" href="index.php">Lihat berita terbaru</a>
        </div>
    <?php else: ?>
        <article>
            <header class="news-article__header">
                <span class="news-category"><?= h($article['nama_kategori'] ?? 'Umum'); ?></span>
                <h1><?= h($article['judul_berita']); ?></h1>
                <div class="news-article__meta">
                    <i class="bi bi-calendar3" aria-hidden="true"></i>
                    <?= h($article['tanggal_berita']); ?>
                </div>
            </header>

            <?php if (!empty($article['gambar_berita'])): ?>
                <img
                    class="news-article__cover"
                    src="images/<?= h(rawurlencode((string) $article['gambar_berita'])); ?>"
                    alt="<?= h($article['judul_berita']); ?>"
                    loading="eager">
            <?php endif; ?>

            <div class="news-article__content"><?= nl2br(h($article['isi_berita'])); ?></div>
        </article>

        <section class="news-comments" id="comments" aria-labelledby="comments-heading">
            <h2 id="comments-heading">Diskusi pembaca</h2>
            <p class="news-comments__intro">Sampaikan pendapat dengan sopan dan tetap menghargai pembaca lain.</p>

            <?php if ($errors): ?>
                <div class="news-alert" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <p><?= h($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="news-form" action="detail_berita.php?id_berita=<?= $idBerita; ?>#comments" method="post">
                <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']); ?>">
                <label for="nama-komentar">Nama</label>
                <input id="nama-komentar" type="text" name="nama_k" maxlength="255" autocomplete="name" required>
                <label for="isi-komentar">Komentar</label>
                <textarea id="isi-komentar" name="isi_k" maxlength="10000" required placeholder="Tulis komentarmu di sini..."></textarea>
                <button type="submit" name="tbh" value="1"><i class="bi bi-chat-dots" aria-hidden="true"></i> Kirim komentar</button>
            </form>

            <?php if ($comments): ?>
                <div class="news-comment-list">
                    <?php foreach ($comments as $comment): ?>
                        <?php $commentId = (string) $comment['id_k']; ?>
                        <article class="news-comment">
                            <div class="news-comment__top">
                                <strong><?= h($comment['nama_k']); ?></strong>
                                <span class="news-comment__date"><?= h($comment['tanggal_k']); ?></span>
                            </div>
                            <p class="news-comment__text"><?= nl2br(h($comment['isi_k'])); ?></p>

                            <?php foreach (($repliesByComment[$commentId] ?? []) as $reply): ?>
                                <div class="news-comment__reply">
                                    <div class="news-comment__top">
                                        <strong><?= h($reply['nama_bk']); ?></strong>
                                        <span class="news-comment__date"><?= h($reply['tanggal_bk']); ?></span>
                                    </div>
                                    <p class="news-comment__text"><?= nl2br(h($reply['isi_bk'])); ?></p>
                                </div>
                            <?php endforeach; ?>

                            <form class="news-form news-comment__reply" action="detail_berita.php?id_berita=<?= $idBerita; ?>#comments" method="post">
                                <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']); ?>">
                                <input type="hidden" name="kode_k" value="<?= (int) $comment['id_k']; ?>">
                                <label for="nama-balasan-<?= (int) $comment['id_k']; ?>">Nama untuk balasan</label>
                                <input id="nama-balasan-<?= (int) $comment['id_k']; ?>" type="text" name="nama_k" maxlength="255" autocomplete="name" required>
                                <label for="isi-balasan-<?= (int) $comment['id_k']; ?>">Balasan</label>
                                <textarea id="isi-balasan-<?= (int) $comment['id_k']; ?>" name="isi_k" maxlength="10000" required placeholder="Tulis balasan..."></textarea>
                                <button type="submit" name="bls" value="1"><i class="bi bi-reply" aria-hidden="true"></i> Balas komentar</button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="news-empty" style="margin-top: 24px;">
                    <h3>Jadilah pembaca pertama yang berdiskusi</h3>
                    <p>Belum ada komentar untuk artikel ini.</p>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>