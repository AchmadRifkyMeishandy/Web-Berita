<?php
	@session_start();
	include '../controllers/connect.php';
	if(@$_SESSION['admin']){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php
        include "link.php";
       ?>
    </head>
    <body class="sb-nav-fixed">
       <?php
        include "header.php";
       ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                    include "menu.php";
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Komentar</h1>
                        
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <a href="t_komentar.php" class="btn btn-success">Tambah</a>
                            </div>

                            
                            <div class="card-body">
                                <?php
                                    $kat=mysqli_query($db,"select*from komentar");
                                    $no=0;
                                ?>
                                <table id="datatablesSimple">
                                    <thead>
                                        
                                        <tr>
                                            <th width="1%">No</th>
                                            <th >Komentar</th>
                                            <th >Kode Berita</th>
                                            <th width="20%">Tanggal</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                       
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                            while($k=mysqli_fetch_array($kat)){
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><?= $no;?></td>
                                            <td><?= $k['isi_k'];?></td>
                                            <td><?= $k['kode_berita'];?></td>
                                            <td><?= $k['tanggal_k'];?></td>
                                            <td><a href="komentar.php?id_k=<?= $k['id_k'];?>&
                                            kode_berita=<?= $k['kode_berita'];?>">Hapus</a></td>
                                            
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </main>
               <?php
                    include "footer.php";
               ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php
                                if(@$_GET['id_k']){
                                    $d="delete from komentar where id_k='".@$_GET['id_k']."'";
                                    mysqli_query($db,$d);
                                    echo '<script language="javascript">   
                                    window.location="komentar.php?page=hapus";  
                                    </script>'; 
                                }
                                ?>
<?php
  }else{
?>
  <script language="javascript">  
 window.location="login.php"
 </script>

<?php
  }
?>