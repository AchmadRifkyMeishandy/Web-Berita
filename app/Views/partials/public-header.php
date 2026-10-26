<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav" aria-label="Navigasi utama">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?= e(url('home')); ?>" aria-label="Beranda Berita Indonesia">
            <span class="brand-mark" aria-hidden="true">BI</span>
            <span class="brand-copy">
                Berita Indonesia
                <small>Kabar dan perspektif</small>
            </span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive"
            aria-expanded="false"
            aria-label="Buka atau tutup menu"
        >
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= e(url('home')); ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= e(url('articles.index')); ?>">Semua berita</a>
                </li>

                <?php foreach (($navigationCategories ?? []) as $navigationCategory): ?>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="<?= e(url('articles.index', ['category_id' => (int) $navigationCategory['id']])); ?>"
                        >
                            <?= e($navigationCategory['name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= e(url('home')); ?>#tentang">Tentang</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
