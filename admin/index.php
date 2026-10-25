<?php
session_start();

if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../controllers/connect.php';

$stats = [
    'berita' => 0,
    'kategori' => 0,
    'komentar' => 0,
];

$tables = [
    'berita' => 'berita',
    'kategori' => 'kategori',
    'komentar' => 'komentar',
];

foreach ($tables as $key => $table) {
    $result = mysqli_query($db, "SELECT COUNT(*) AS total FROM `" . $table . "`");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stats[$key] = (int) ($row['total'] ?? 0);
        mysqli_free_result($result);
    }
}
?>
<!doctype html>
<html lang="id">
<?php include __DIR__ . '/link.php'; ?>
<body class="sb-nav-fixed">
    <?php include __DIR__ . '/header.php'; ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include __DIR__ . '/menu.php'; ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <header class="admin-welcome">
                        <p class="admin-welcome__eyebrow">Ringkasan pengelolaan konten</p>
                        <h1>Dashboard</h1>
                        <p>Selamat datang di panel administrasi Berita Indonesia. Kelola berita, kategori, dan komentar dari satu tempat.</p>
                    </header>

                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6 col-xl-4">
                            <section class="admin-stat admin-stat--blue">
                                <div class="admin-stat__icon"><i class="fas fa-newspaper" aria-hidden="true"></i></div>
                                <div class="admin-stat__label">Jumlah berita</div>
                                <div class="admin-stat__value"><?= number_format($stats['berita'], 0, ',', '.'); ?></div>
                                <a href="berita.php">Kelola berita <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                            </section>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <section class="admin-stat admin-stat--gold">
                                <div class="admin-stat__icon"><i class="fas fa-tags" aria-hidden="true"></i></div>
                                <div class="admin-stat__label">Jumlah kategori</div>
                                <div class="admin-stat__value"><?= number_format($stats['kategori'], 0, ',', '.'); ?></div>
                                <a href="kategori.php">Kelola kategori <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                            </section>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <section class="admin-stat admin-stat--teal">
                                <div class="admin-stat__icon"><i class="fas fa-comments" aria-hidden="true"></i></div>
                                <div class="admin-stat__label">Jumlah komentar</div>
                                <div class="admin-stat__value"><?= number_format($stats['komentar'], 0, ',', '.'); ?></div>
                                <a href="komentar.php">Kelola komentar <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                            </section>
                        </div>
                    </div>

                    <section class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-bolt me-2" aria-hidden="true"></i>
                            Aksi cepat
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Pilih tindakan yang ingin dilakukan.</p>
                            <div class="admin-quick-actions">
                                <a class="btn btn-primary" href="t_berita.php"><i class="fas fa-plus me-2" aria-hidden="true"></i>Tambah berita</a>
                                <a class="btn btn-outline-primary" href="t_kategori.php"><i class="fas fa-tag me-2" aria-hidden="true"></i>Tambah kategori</a>
                                <a class="btn btn-outline-primary" href="../index.php" target="_blank" rel="noopener"><i class="fas fa-external-link-alt me-2" aria-hidden="true"></i>Lihat website</a>
                            </div>
                        </div>
                    </section>

                    <section class="admin-note">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div>
                            <strong>Catatan pengembangan</strong>
                            <p class="mb-0">Halaman ini adalah bagian dari proyek pembelajaran. Sebelum digunakan di server publik, pastikan seluruh operasi admin memakai otorisasi, validasi data, query terparameterisasi, dan perlindungan CSRF.</p>
                        </div>
                    </section>
                </div>
            </main>

            <?php include __DIR__ . '/footer.php'; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>