<?php
require_once __DIR__ . '/controllers/connect.php';

$articles = [];
$queryArticles = mysqli_query(
    $db,
    "SELECT b.id_berita, b.judul_berita, b.isi_berita, b.tanggal_berita,
            b.gambar_berita, k.nama_kategori
     FROM berita AS b
     LEFT JOIN kategori AS k ON k.id_kategori = b.kode_kategori
     ORDER BY b.id_berita DESC"
);

if ($queryArticles) {
    while ($row = mysqli_fetch_assoc($queryArticles)) {
        $articles[] = $row;
    }
}

$articleCount = count($articles);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita Indonesia — Kabar dan Perspektif</title>
    <meta name="description" content="Baca berita Indonesia dari berbagai kategori seperti sosial, politik, dan budaya.">
    <?php include __DIR__ . '/link.php'; ?>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main>
    <section class="news-hero" id="home">
        <div class="news-hero__inner">
            <div>
                <p class="news-eyebrow">Informasi · Perspektif · Cerita</p>
                <h1>Kabar Indonesia,<br><span>lebih dekat.</span></h1>
                <p class="news-hero__lead">
                    Temukan berita dan cerita dari berbagai sudut pandang.
                    Baca informasi yang membantu kita memahami hal-hal di sekitar.
                </p>
                <a class="news-button" href="#berita-terbaru">
                    Jelajahi berita <i class="bi bi-arrow-down-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="news-hero__visual" aria-hidden="true">
                <div class="news-orb">BI</div>
                <div class="news-hero__note">Ruang untuk mengikuti kabar, menemukan konteks, dan memperluas perspektif.</div>
            </div>
        </div>
    </section>

    <section class="news-section" id="berita-terbaru">
        <div class="news-shell">
            <div class="news-section__heading">
                <div>
                    <p class="news-eyebrow">Pilihan redaksi</p>
                    <h2>Berita terbaru</h2>
                </div>
                <span class="news-count"><?= number_format($articleCount, 0, ',', '.'); ?> artikel</span>
            </div>

            <?php if ($articleCount > 0): ?>
                <div class="news-grid">
                    <?php foreach ($articles as $article): ?>
                        <?php
                        $articleId = (int) $article['id_berita'];
                        $title = htmlspecialchars((string) $article['judul_berita'], ENT_QUOTES, 'UTF-8');
                        $category = htmlspecialchars((string) ($article['nama_kategori'] ?? 'Umum'), ENT_QUOTES, 'UTF-8');
                        $date = htmlspecialchars((string) $article['tanggal_berita'], ENT_QUOTES, 'UTF-8');
                        $image = rawurlencode((string) $article['gambar_berita']);
                        $alt = $title !== '' ? $title : 'Gambar berita';
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
                                <img src="images/<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?= $alt; ?>" loading="lazy">
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
                    <h3>Belum ada berita untuk ditampilkan</h3>
                    <p>Artikel yang tersedia akan muncul di halaman ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="news-section news-section--compact" id="signup">
        <div class="news-shell">
            <div class="news-section__heading">
                <div>
                    <p class="news-eyebrow">Tentang website</p>
                    <h2>Membaca kabar, memahami cerita.</h2>
                </div>
            </div>
            <p class="news-article__content">
                Berita Indonesia adalah proyek pembelajaran pengembangan web untuk mengelola artikel,
                kategori, serta percakapan pembaca melalui PHP dan MySQL.
            </p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>