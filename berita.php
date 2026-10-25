<?php
require_once __DIR__ . '/controllers/connect.php';

$categoryId = null;
$invalidCategory = false;
if (isset($_GET['id_kategori'])) {
    $categoryId = filter_var($_GET['id_kategori'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($categoryId === false) {
        $invalidCategory = true;
        $categoryId = null;
    }
}

$categoryName = null;
if ($categoryId !== null) {
    $categoryStatement = mysqli_prepare($db, "SELECT nama_kategori FROM kategori WHERE id_kategori = ? LIMIT 1");
    if ($categoryStatement) {
        mysqli_stmt_bind_param($categoryStatement, 'i', $categoryId);
        mysqli_stmt_execute($categoryStatement);
        $categoryResult = mysqli_stmt_get_result($categoryStatement);
        $categoryRow = $categoryResult ? mysqli_fetch_assoc($categoryResult) : null;
        $categoryName = $categoryRow['nama_kategori'] ?? null;
        mysqli_stmt_close($categoryStatement);
    }
}

$articles = [];
if (!$invalidCategory && ($categoryId === null || $categoryName !== null)) {
    if ($categoryId !== null) {
        $articleStatement = mysqli_prepare(
            $db,
            "SELECT b.id_berita, b.judul_berita, b.isi_berita, b.tanggal_berita,
                    b.gambar_berita, k.nama_kategori
             FROM berita AS b
             LEFT JOIN kategori AS k ON k.id_kategori = b.kode_kategori
             WHERE b.kode_kategori = ?
             ORDER BY b.id_berita DESC"
        );
        if ($articleStatement) {
            $categoryIdString = (string) $categoryId;
            mysqli_stmt_bind_param($articleStatement, 's', $categoryIdString);
            mysqli_stmt_execute($articleStatement);
            $articleResult = mysqli_stmt_get_result($articleStatement);
            if ($articleResult) {
                while ($row = mysqli_fetch_assoc($articleResult)) {
                    $articles[] = $row;
                }
            }
            mysqli_stmt_close($articleStatement);
        }
    } else {
        $articleResult = mysqli_query(
            $db,
            "SELECT b.id_berita, b.judul_berita, b.isi_berita, b.tanggal_berita,
                    b.gambar_berita, k.nama_kategori
             FROM berita AS b
             LEFT JOIN kategori AS k ON k.id_kategori = b.kode_kategori
             ORDER BY b.id_berita DESC"
        );
        if ($articleResult) {
            while ($row = mysqli_fetch_assoc($articleResult)) {
                $articles[] = $row;
            }
        }
    }
}

$articleCount = count($articles);
$pageHeading = $categoryName !== null ? 'Berita: ' . $categoryName : 'Semua berita';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageHeading, ENT_QUOTES, 'UTF-8'); ?> — Berita Indonesia</title>
    <meta name="description" content="Jelajahi artikel dan berita Indonesia berdasarkan kategori.">
    <?php include __DIR__ . '/link.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main>
    <section class="news-hero">
        <div class="news-hero__inner">
            <div>
                <p class="news-eyebrow">Jelajahi topik</p>
                <h1><?= htmlspecialchars($pageHeading, ENT_QUOTES, 'UTF-8'); ?><br><span>untuk perspektif baru.</span></h1>
                <p class="news-hero__lead">
                    Temukan artikel yang kamu cari dan ikuti cerita dari berbagai kategori.
                </p>
                <a class="news-button" href="index.php#berita-terbaru">
                    Lihat berita terbaru <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="news-hero__visual" aria-hidden="true">
                <div class="news-orb">BI</div>
                <div class="news-hero__note">Pilih topik yang menarik perhatianmu, lalu lanjutkan membaca.</div>
            </div>
        </div>
    </section>

    <section class="news-section" id="daftar-berita">
        <div class="news-shell">
            <div class="news-section__heading">
                <div>
                    <p class="news-eyebrow">Arsip artikel</p>
                    <h2><?= htmlspecialchars($pageHeading, ENT_QUOTES, 'UTF-8'); ?></h2>
                </div>
                <span class="news-count"><?= number_format($articleCount, 0, ',', '.'); ?> artikel</span>
            </div>

            <?php if ($invalidCategory): ?>
                <div class="news-empty">
                    <h3>Kategori tidak valid</h3>
                    <p>Tautan kategori tidak sesuai. Silakan pilih kategori dari menu navigasi.</p>
                </div>
            <?php elseif ($categoryId !== null && $categoryName === null): ?>
                <div class="news-empty">
                    <h3>Kategori tidak ditemukan</h3>
                    <p>Kategori yang kamu cari tidak tersedia atau sudah tidak aktif.</p>
                    <a class="news-read-link" href="index.php">Kembali ke beranda</a>
                </div>
            <?php elseif ($articleCount > 0): ?>
                <div class="news-grid">
                    <?php foreach ($articles as $article): ?>
                        <?php
                        $articleId = (int) $article['id_berita'];
                        $title = htmlspecialchars((string) $article['judul_berita'], ENT_QUOTES, 'UTF-8');
                        $category = htmlspecialchars((string) ($article['nama_kategori'] ?? 'Umum'), ENT_QUOTES, 'UTF-8');
                        $date = htmlspecialchars((string) $article['tanggal_berita'], ENT_QUOTES, 'UTF-8');
                        $image = htmlspecialchars(rawurlencode((string) $article['gambar_berita']), ENT_QUOTES, 'UTF-8');
                        $excerpt = trim(preg_replace('/\\s+/', ' ', strip_tags((string) $article['isi_berita'])));
                        if (function_exists('mb_strlen') && mb_strlen($excerpt, 'UTF-8') > 150) {
                            $excerpt = mb_substr($excerpt, 0, 150, 'UTF-8') . '…';
                        } elseif (strlen($excerpt) > 150) {
                            $excerpt = substr($excerpt, 0, 147) . '...';
                        }
                        $excerpt = htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8');
                        ?>
                        <article class="news-card">
                            <a class="news-card__image" href="detail_berita.php?id_berita=<?= $articleId; ?>" aria-label="Baca: <?= $title; ?>">
                                <img src="images/<?= $image; ?>" alt="<?= $title; ?>" loading="lazy">
                            </a>
                            <div class="news-card__body">
                                <span class="news-category"><?= $category; ?></span>
                                <h3><a href="detail_berita.php?id_berita=<?= $articleId; ?>"><?= $title; ?></a></h3>
                                <p class="news-card__excerpt"><?= $excerpt; ?></p>
                                <div class="news-card__meta">
                                    <span><?= $date; ?></span>
                                    <a class="news-read-link" href="detail_berita.php?id_berita=<?= $articleId; ?>">Baca berita <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="news-empty">
                    <h3>Belum ada berita di kategori ini</h3>
                    <p>Silakan pilih kategori lain dari menu navigasi atau kembali ke beranda.</p>
                    <a class="news-read-link" href="index.php">Kembali ke beranda</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>