<?php
$currentPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$adminDisplayName = $_SESSION['admin_name'] ?? 'Administrator';
$adminDisplayName = htmlspecialchars((string) $adminDisplayName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" aria-label="Navigasi administrasi">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu utama</div>
            <a class="nav-link <?= $currentPage === 'index.php' ? 'active' : ''; ?>" href="index.php">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-line" aria-hidden="true"></i></div>
                Dashboard
            </a>

            <div class="sb-sidenav-menu-heading">Konten</div>
            <a class="nav-link <?= in_array($currentPage, ['berita.php', 'e_berita.php'], true) ? 'active' : ''; ?>" href="berita.php">
                <div class="sb-nav-link-icon"><i class="fas fa-newspaper" aria-hidden="true"></i></div>
                Kelola Berita
            </a>
            <a class="nav-link <?= $currentPage === 't_berita.php' ? 'active' : ''; ?>" href="t_berita.php">
                <div class="sb-nav-link-icon"><i class="fas fa-plus-circle" aria-hidden="true"></i></div>
                Tambah Berita
            </a>
            <a class="nav-link <?= in_array($currentPage, ['kategori.php', 'e_kategori.php'], true) ? 'active' : ''; ?>" href="kategori.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tags" aria-hidden="true"></i></div>
                Kelola Kategori
            </a>
            <a class="nav-link <?= $currentPage === 't_kategori.php' ? 'active' : ''; ?>" href="t_kategori.php">
                <div class="sb-nav-link-icon"><i class="fas fa-plus-circle" aria-hidden="true"></i></div>
                Tambah Kategori
            </a>
            <a class="nav-link <?= $currentPage === 'komentar.php' ? 'active' : ''; ?>" href="komentar.php">
                <div class="sb-nav-link-icon"><i class="fas fa-comments" aria-hidden="true"></i></div>
                Kelola Komentar
            </a>
            <a class="nav-link <?= $currentPage === 't_komentar.php' ? 'active' : ''; ?>" href="t_komentar.php">
                <div class="sb-nav-link-icon"><i class="fas fa-comment-medical" aria-hidden="true"></i></div>
                Tambah Komentar
            </a>
        </div>
    </div>

    <div class="sb-sidenav-footer">
        <div class="small">Masuk sebagai</div>
        <strong><?= $adminDisplayName; ?></strong>
    </div>
</nav>