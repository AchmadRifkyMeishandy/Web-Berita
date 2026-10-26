<main>
    <section class="news-hero" id="home" aria-labelledby="home-heading">
        <div class="news-hero__inner">
            <div>
                <p class="news-eyebrow">Informasi · Perspektif · Cerita</p>
                <h1 id="home-heading">Kabar Indonesia,<br><span>lebih dekat.</span></h1>
                <p class="news-hero__lead">
                    Temukan berita dan cerita dari berbagai sudut pandang. Baca informasi yang
                    membantu kita memahami hal-hal di sekitar.
                </p>
                <a class="news-button" href="<?= e(url('articles.index')); ?>">
                    Jelajahi berita <i class="bi bi-arrow-down-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="news-hero__visual" aria-hidden="true">
                <div class="news-orb">BI</div>
                <div class="news-hero__note">
                    Ruang untuk mengikuti kabar, menemukan konteks, dan memperluas perspektif.
                </div>
            </div>
        </div>
    </section>

    <section class="news-section" id="berita-terbaru" aria-labelledby="latest-news-heading">
        <div class="news-shell">
            <div class="news-section__heading">
                <div>
                    <p class="news-eyebrow">Pilihan redaksi</p>
                    <h2 id="latest-news-heading">Berita terbaru</h2>
                    <p class="news-section__subheading">
                        Ikuti kabar terbaru dari beragam topik dan sudut pandang.
                    </p>
                </div>
                <span class="news-count">
                    <?= number_format((int) $articleCount, 0, ',', '.'); ?> artikel tersedia
                </span>
            </div>

            <?php if ($articles): ?>
                <div class="news-grid">
                    <?php foreach ($articles as $index => $article): ?>
                        <article class="news-card">
                            <a
                                class="news-card__image"
                                href="<?= e(url('articles.show', ['id' => (int) $article['id']])); ?>"
                                aria-label="Baca: <?= e($article['title']); ?>"
                            >
                                <img
                                    src="<?= e(image_url($article['image_path'])); ?>"
                                    alt="<?= e($article['title']); ?>"
                                    loading="<?= $index === 0 ? 'eager' : 'lazy'; ?>"
                                    <?= $index === 0 ? 'fetchpriority="high"' : ''; ?>
                                >
                            </a>

                            <div class="news-card__body">
                                <span class="news-category">
                                    <?= e($article['category_name'] ?? 'Umum'); ?>
                                </span>
                                <h3>
                                    <a href="<?= e(url('articles.show', ['id' => (int) $article['id']])); ?>">
                                        <?= e($article['title']); ?>
                                    </a>
                                </h3>
                                <p class="news-card__excerpt">
                                    <?= e(text_excerpt((string) $article['body'], 150)); ?>
                                </p>
                                <div class="news-card__meta">
                                    <span><?= e(format_date($article['published_at'])); ?></span>
                                    <a
                                        class="news-read-link"
                                        href="<?= e(url('articles.show', ['id' => (int) $article['id']])); ?>"
                                    >
                                        Baca berita <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if ((int) $articleCount > count($articles)): ?>
                    <div class="news-home__more">
                        <p>
                            Menampilkan <?= count($articles); ?> dari
                            <?= number_format((int) $articleCount, 0, ',', '.'); ?> artikel.
                        </p>
                        <a class="news-button news-button--light" href="<?= e(url('articles.index')); ?>">
                            Lihat semua berita <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="news-empty">
                    <h3>Belum ada berita untuk ditampilkan</h3>
                    <p>Artikel yang tersedia akan muncul di halaman ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section
        class="news-section news-section--compact news-about"
        id="tentang"
        aria-labelledby="about-heading"
    >
        <div class="news-shell news-about__inner">
            <div class="news-about__copy">
                <p class="news-eyebrow">Tentang website</p>
                <h2 id="about-heading">Membaca kabar, memahami cerita.</h2>
            </div>
            <div class="news-about__details">
                <p>
                    Berita Indonesia adalah proyek pembelajaran pengembangan web untuk mengelola
                    artikel, kategori, serta percakapan pembaca melalui PHP dan MySQL.
                </p>
                <div class="news-tech-list" aria-label="Teknologi yang digunakan">
                    <span>PHP</span>
                    <span>MySQL</span>
                    <span>Bootstrap</span>
                    <span>MVC</span>
                </div>
            </div>
        </div>
    </section>
</main>
