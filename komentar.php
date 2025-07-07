<!DOCTYPE html>
<?php
    include "controllers/connect.php";
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <?php
            include "link.php";
        ?>
    </head>
    <body>
        <!-- Navigation-->
        <?php
        include "header.php";
        ?>
        <!-- Page Header-->
        
        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <!-- Post preview-->
                    <?php
                    $konten=mysqli_query($db,"select*from berita where id_berita='$_GET[id_berita]'");
                    while($k=mysqli_fetch_array($konten)){
                    ?>
                    <div class="post-preview">
                            <p></p>
                            <br />
                            <br />
                            <h2>
                                Kategori 
                                <?php
                                    $kategori=mysqli_query($db,"select*from kategori where id_kategori='$k[kode_kategori]'");
                                    $kat=mysqli_fetch_array($kategori);
                                    echo $kat['nama_kategori'];
                                ?>
                            </h2>
                            
                            <p class="post-title"><b><?= $k['judul_berita'];?></b></p>
                            <img width="400px" src="images/<?= $k['gambar_berita'];?>">
                            <div style="font-size:14px; color:#999;">
                            Posted by
                            <?= $k['tanggal_berita'];?>
                            </div>
                            
                            <?= $k['isi_berita'];?>
                        
                    </div>
                    <?php
                    }
                    ?>
                    <br />
                    <font color="#00F">
                    <b>KOMENTAR:</b><br />
                    </font>
                    <form action="detail_berita.php?id_berita=<?= $_GET['id_berita'];?>" method="POST">
                        <input type="text" placeholder="Tuliskan Nama Anda" name="nama_k" style="margin:1px 2px 1px 2px; border-radius:3px; width:100%;" /><br />
                        <input type="hidden" placeholder="Tuliskan Nama Anda" name="kode_berita" value="<?= $_GET['id_berita'];?>" style="margin:1px 2px 1px 2px; border-radius:3px; width:100%;" /><br />
                        <textarea name="isi_k" style="margin:1px 2px 1px 2px; border-radius:2px; width:100%;"></textarea>
                        <input type="submit" value="POST" name="tbh" style="margin:1px 2px 1px 2px; background-color:#00F; color:#FFF; border-radius:2px; width:100%;" />
                    </form>
                    <?php
                        $komentar=mysqli_query($db,"select*from komentar where kode_berita='$_GET[id_berita]'");
                        while($kom=mysqli_fetch_array($komentar)){
                    ?>
                    <br />
                    <?= $kom['nama_k'];?><br />
                    <font size="2px"><?= $kom['tanggal_k'];?></font><br />
                    <?= $kom['isi_k'];?>
                    <hr />
                    <?php
                    }
                    ?>
                    <!-- Divider-->
                    <hr class="my-4" />
                    <!-- Pager-->
                    </div>
            </div>
        </div>
        <?php
        if(@$_POST['tbh']){
            $id_bk=@$_POST['id_bk'];
            $isi_bk=@$_POST['isi_bk'];
            $kode_user=@$_POST['kode_user'];
            $date=date('d F Y');
        $sql ="insert into komentar(nama_k,isi_k,tanggal_k,kode_berita)
        values('".$id_bk."','".$isi_bk."','".$date."','".$kode_user."')";
        mysqli_query($db,$sql);
        ?>
        <script language="javascript">  
        window.location="?id_berita=<?= @$_GET['id_berita'];?>"
        </script>
        <?php
        }
        ?>
        <!-- Footer-->
        <?php
            include "footer.php";
        ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
