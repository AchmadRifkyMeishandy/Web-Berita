<main>
    <section class="news-hero" aria-labelledby="archive-heading">
        <div class="news-hero__inner">
            <div>
                <p class="news-eyebrow">Jelajahi topik</p>
                <h1 id="archive-heading">
                    <?= e($category ? 'Berita: ' . $category['name'] : 'Semua berita'); ?><br>
                    <span>Berita Indonesia.</span>
                </h1>
                <p class="news-hero__lead">
                    Temukan artikel sesuai kategori dan ikuti berita yang ingin kamu baca.
                </p>
                <a class="news-button" href="<?= e(url('home')); ?>">
                    Kembali ke beranda <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="news-hero__visual" aria-hidden="true">
                <div class="news-orb">BI</div>
                <div class="news-hero__note">Beragam topik, satu tempat.</div>
            </div>
        </div>
    </section>

    <section class="news-section" aria-label="Daftar artikel">
        <div class="news-shell">
            <div class="news-section__heading">
                <div>
                    <p class="news-eyebrow">Arsip berita</p>
                    <h2><?= e($category ? $category['name'] : 'Semua artikel'); ?></h2>
                    <p class="news-section__subheading">
                        <?= number_format((int) $pagination['total'], 0, ',', '.'); ?> artikel ditemukan.
                    </p>
                </div>
                <span class="news-count">
                    Halaman <?= (int) $pagination['page']; ?> dari <?= (int) $pagination['totalPages']; ?>
                </span>
            </div>

            <?php if ($errorMessage): ?>
                <div class="news-alert" role="alert">
                    <p><?= e($errorMessage); ?></p>
                </div>
            <?php elseif ($pagination['articles']): ?>
                <div class="news-grid">
                    <?php foreach ($pagination['articles'] as $article): ?>
                        <article class="news-card">
                            <a
                                class="news-card__image"
                                href="<?= e(url('articles.show', ['id' => (int) $article['id']])); ?>"
                            >
                                <img
                                    src="<?= e(image_url($article['image_path'])); ?>"
                                    alt="<?= e($article['title']); ?>"
                                    loading="lazy"
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
                                    <?= e(text_excerpt((string) $article['excerpt'], 150)); ?>
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

                <?php if ((int) $pagination['totalPages'] > 1): ?>
                    <nav class="news-pagination" aria-label="Paginasi berita">
                        <?php if ((int) $pagination['page'] > 1): ?>
                            <a
                                class="news-pagination__link"
                                href="<?= e(url('articles.index', array_filter([
                                    'category_id' => $selectedCategoryId,
                                    'page' => $pagination['page'] - 1,
                                ]))); ?>"
                            >Sebelumnya</a>
                        <?php endif; ?>

                        <span class="news-pagination__status">
                            Halaman <?= (int) $pagination['page']; ?> / <?= (int) $pagination['totalPages']; ?>
                        </span>

                        <?php if ((int) $pagination['page'] < (int) $pagination['totalPages']): ?>
                            <a
                                class="news-pagination__link"
                                href="<?= e(url('articles.index', array_filter([
                                    'category_id' => $selectedCategoryId,
                                    'page' => $pagination['page'] + 1,
                                ]))); ?>"
                            >Berikutnya</a>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="news-empty">
                    <h3>Belum ada artikel</h3>
                    <p>Belum ada berita dalam kategori ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
