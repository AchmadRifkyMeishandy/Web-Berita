<?php
	@session_start();
	include '../controllers/connect.php';
	if(@$_SESSION['admin']){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Berita Indonesia Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
            <!-- Navbar-->
            <?php
                include "header.php";
                ?>

                <?php
                include "menu.php"
                ?>
            <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit Kategori</h1>
                        
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Isi Data Kategori
                            </div>
                            <div class="card-body">
                            <div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="kategori.php" class="btn btn-warning">Daftar Kategori</a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
									<br />

                                    <?php 
                                          $ekat=mysqli_query($db,"select*from kategori where id_kategori='$_GET[id_kategori]'");
                                           while($ek=mysqli_fetch_array($ekat)){
                                    ?>

									<form class="form-horizontal form-label-left" method="POST" action="../controllers/proses_edit_kategori.php?id_kategori=<?= $_GET['id_kategori'];?> enctype="multipart/form-data">
                                           
										<div class="form-group row ">
											<label class="control-label col-md-3 col-sm-3 ">Nama Kategori<span class="required">*</span></label>
											<div class="col-md-9 col-sm-9 ">
												<input type="text" value="<?=$ek['nama_kategori'];?>" class="form-control" id="autocomplete-custom-append" name="nama_kategori" placeholder="Nama Kategori" required="required">
                    
											</div>
										</div>
										
									
										
                                        
										
										<br /><br />
										<div class="form-group">
											<div class="col-md-9 col-sm-9  offset-md-3">
											
												<a href=""><button type="reset" class="btn btn-primary">Reset</button></a>
												<input type="submit" name="edit" class="btn btn-success" value="Simpan" />
											</div>
										</div>

									</form>
                                           
                                    <?php 
                                           }
                                    ?>
								</div>
								
							</div>
						</div>
					</div>
                            </div>
                        </div>
                    </div>
               
                <?php
                include "footer.php";
                ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php
  }else{
?>
  <script language="javascript">  
 window.location="login.php"
 </script>
<?php
  }
?>