<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Berita Indonesia</a>

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0"
            id="sidebarToggle" type="button" aria-label="Buka atau tutup navigasi">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>

    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#"
               role="button" data-bs-toggle="dropdown" aria-expanded="false"
               aria-label="Menu akun">
                <i class="fas fa-user fa-fw" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="../controllers/logout.php?page=admin"
                       title="Keluar dari akun"
                       onclick="return confirm('Apakah kamu yakin ingin keluar?')">
                        <i class="fas fa-sign-out-alt me-2" aria-hidden="true"></i>Keluar
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>