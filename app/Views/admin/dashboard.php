<section class="admin-dashboard-hero">
    <div>
        <span class="admin-hero-label">Halo, <?= e(current_admin_name()); ?></span>
        <h2>Selamat datang kembali.</h2>
        <p>Semua yang kamu kelola ada di satu tempat. Pilih bagian yang ingin diperbarui.</p>
    </div>
    <span class="admin-hero-art" aria-hidden="true">
        <i class="fas fa-newspaper"></i>
    </span>
</section>

<div class="row g-3 g-xl-4 mb-4">
    <div class="col-12 col-md-6 col-xl-4">
        <section class="admin-stat">
            <span class="admin-stat__icon"><i class="fas fa-newspaper"></i></span>
            <div class="admin-stat__label">Jumlah berita</div>
            <div class="admin-stat__value"><?= number_format($articleCount, 0, ',', '.'); ?></div>
            <a href="<?= e(url('admin.articles.index')); ?>">
                Kelola berita <i class="fas fa-arrow-right"></i>
            </a>
        </section>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <section class="admin-stat admin-stat--gold">
            <span class="admin-stat__icon"><i class="fas fa-tags"></i></span>
            <div class="admin-stat__label">Jumlah kategori</div>
            <div class="admin-stat__value"><?= number_format($categoryCount, 0, ',', '.'); ?></div>
            <a href="<?= e(url('admin.categories.index')); ?>">
                Kelola kategori <i class="fas fa-arrow-right"></i>
            </a>
        </section>
    </div>

    <div class="col-12 col-md-6 col-xl-4">
        <section class="admin-stat admin-stat--teal">
            <span class="admin-stat__icon"><i class="fas fa-comments"></i></span>
            <div class="admin-stat__label">Jumlah komentar</div>
            <div class="admin-stat__value"><?= number_format($commentCount, 0, ',', '.'); ?></div>
            <a href="<?= e(url('admin.comments.index')); ?>">
                Kelola komentar <i class="fas fa-arrow-right"></i>
            </a>
        </section>
    </div>
</div>

<section class="card admin-card mb-4">
    <div class="card-header admin-card-header">
        <div>
            <h2>Aksi cepat</h2>
            <p>Jalankan tugas yang sering digunakan.</p>
        </div>
        <span class="admin-section-icon"><i class="fas fa-bolt"></i></span>
    </div>
    <div class="card-body">
        <div class="admin-quick-actions">
            <a class="btn btn-primary" href="<?= e(url('admin.articles.create')); ?>">
                <i class="fas fa-plus me-2"></i>Tambah berita
            </a>
            <a class="btn btn-outline-primary" href="<?= e(url('admin.categories.create')); ?>">
                <i class="fas fa-tag me-2"></i>Tambah kategori
            </a>
            <a class="btn btn-outline-primary" href="<?= e(url('admin.comments.index')); ?>">
                <i class="fas fa-comments me-2"></i>Kelola komentar
            </a>
        </div>
    </div>
</section>

<div class="admin-note">
    <i class="fas fa-info-circle"></i>
    <div>
        <strong>Tentang struktur proyek</strong>
        <p class="mb-0">Aplikasi ini memakai pola MVC: Controller mengatur permintaan, Model mengelola data, dan View menampilkan halaman.</p>
    </div>
</div>
