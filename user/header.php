
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#about">Berita indonesia</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        
                        <?php
              $kategori=mysqli_query($db,"select*from kategori");
              while($k=mysqli_fetch_array($kategori)){
          ?>
              <li class="nav-item">
            <a class="nav-link" href="berita.php?id_kategori=<?=$k['id_kategori'];?>"><?= $k['nama_kategori'];?></a>
          </li>
          <?php
              }
          ?>

                        
                        <li class="nav-item"><a class="nav-link" href="#signup">contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>