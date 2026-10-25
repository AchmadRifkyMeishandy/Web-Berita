<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav" aria-label="Navigasi utama">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php" aria-label="Beranda Berita Indonesia">
            <span class="brand-mark" aria-hidden="true">BI</span>
            <span class="brand-copy">
                Berita Indonesia
                <small>Kabar dan perspektif</small>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Buka atau tutup menu">
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                <?php
                if (isset($db) && $db) {
                    $kategoriNav = mysqli_query($db, "SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
                    if ($kategoriNav) {
                        while ($kategoriItem = mysqli_fetch_assoc($kategoriNav)) {
                            $kategoriId = (int) $kategoriItem['id_kategori'];
                            $kategoriNama = htmlspecialchars((string) $kategoriItem['nama_kategori'], ENT_QUOTES, 'UTF-8');
                            echo '<li class="nav-item"><a class="nav-link" href="berita.php?id_kategori=' . $kategoriId . '">' . $kategoriNama . '</a></li>';
                        }
                    }
                }
                ?>
                <li class="nav-item"><a class="nav-link" href="index.php#signup">Tentang</a></li>
            </ul>
        </div>
    </div>
</nav>