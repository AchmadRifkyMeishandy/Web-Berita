<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? 'Panel Admin'); ?> — Berita Indonesia</title>
    <link rel="icon" href="<?= e(asset('favicon.ico')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">
    <link href="<?= e(asset('admin/styles.css')); ?>" rel="stylesheet">
    <link href="<?= e(asset('admin/news-admin-modern.css')); ?>" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" aria-label="Navigasi utama administrasi">
        <a class="navbar-brand ps-3" href="<?= e(url('admin.dashboard')); ?>">
            <span class="admin-brand-mark" aria-hidden="true">BI</span>
            <span>Berita Indonesia</span>
        </a>

        <button
            class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0"
            id="sidebarToggle"
            type="button"
            aria-label="Buka atau tutup navigasi"
        >
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3 pe-3">
            <a class="admin-view-site" href="<?= e(url('home')); ?>" target="_blank" rel="noopener">
                <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                <span>Lihat website</span>
            </a>
            <form action="<?= e(url('admin.logout')); ?>" method="post" class="m-0">
                <?= csrf_input(); ?>
                <button
                    class="btn admin-account-button"
                    type="submit"
                    onclick="return confirm('Yakin ingin keluar dari panel admin?');"
                >
                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                    <span class="d-none d-md-inline">Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    <div id="layoutSidenav">
        <aside id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" aria-label="Navigasi administrasi">
                <div class="sb-sidenav-menu">
                    <div class="admin-sidebar-label">Menu utama</div>
                    <div class="nav">
                        <a
                            class="nav-link <?= str_starts_with($currentRoute, 'admin.dashboard') ? 'active' : ''; ?>"
                            href="<?= e(url('admin.dashboard')); ?>"
                        >
                            <span class="sb-nav-link-icon"><i class="fas fa-chart-line" aria-hidden="true"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </div>

                    <div class="admin-sidebar-label">Konten</div>
                    <div class="nav">
                        <a
                            class="nav-link <?= str_starts_with($currentRoute, 'admin.articles.') ? 'active' : ''; ?>"
                            href="<?= e(url('admin.articles.index')); ?>"
                        >
                            <span class="sb-nav-link-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></span>
                            <span>Kelola Berita</span>
                        </a>
                        <a class="nav-link" href="<?= e(url('admin.articles.create')); ?>">
                            <span class="sb-nav-link-icon"><i class="fas fa-plus-circle" aria-hidden="true"></i></span>
                            <span>Tambah Berita</span>
                        </a>
                        <a
                            class="nav-link <?= str_starts_with($currentRoute, 'admin.categories.') ? 'active' : ''; ?>"
                            href="<?= e(url('admin.categories.index')); ?>"
                        >
                            <span class="sb-nav-link-icon"><i class="fas fa-tags" aria-hidden="true"></i></span>
                            <span>Kelola Kategori</span>
                        </a>
                        <a class="nav-link" href="<?= e(url('admin.categories.create')); ?>">
                            <span class="sb-nav-link-icon"><i class="fas fa-plus-circle" aria-hidden="true"></i></span>
                            <span>Tambah Kategori</span>
                        </a>
                        <a
                            class="nav-link <?= str_starts_with($currentRoute, 'admin.comments.') ? 'active' : ''; ?>"
                            href="<?= e(url('admin.comments.index')); ?>"
                        >
                            <span class="sb-nav-link-icon"><i class="fas fa-comments" aria-hidden="true"></i></span>
                            <span>Kelola Komentar</span>
                        </a>
                    </div>
                </div>

                <div class="sb-sidenav-footer">
                    <div class="admin-user-avatar" aria-hidden="true"><i class="fas fa-user"></i></div>
                    <div class="admin-user-meta">
                        <span>Masuk sebagai</span>
                        <strong><?= e(current_admin_name()); ?></strong>
                    </div>
                </div>
            </nav>
        </aside>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 admin-page-container">
                    <header class="admin-page-heading">
                        <div class="admin-page-heading__copy">
                            <p class="admin-page-eyebrow">Panel administrasi</p>
                            <h1><?= e($pageTitle ?? 'Dashboard'); ?></h1>
                            <p><?= e($pageDescription ?? 'Kelola konten Berita Indonesia dari satu tempat.'); ?></p>
                        </div>
                        <?php if (!empty($pageAction)): ?>
                            <div class="admin-page-heading__action"><?= $pageAction; ?></div>
                        <?php endif; ?>
                    </header>

                    <?php if (!empty($successMessage)): ?>
                        <div class="alert alert-success admin-alert" role="status"><?= e($successMessage); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger admin-alert" role="alert"><?= e($errorMessage); ?></div>
                    <?php endif; ?>

                    <?= $content; ?>
                </div>
            </main>

            <footer class="admin-footer">
                <div class="container-fluid">
                    <span>Berita Indonesia · Panel administrasi</span>
                    <span>&copy; <?= date('Y'); ?></span>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="<?= e(asset('admin/js/scripts.js')); ?>"></script>
    <script src="<?= e(asset('admin/js/datatables-simple-demo.js')); ?>"></script>
</body>
</html>
