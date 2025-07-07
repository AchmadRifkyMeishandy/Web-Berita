<?php
@session_start();
include '../controllers/connect.php';
if (@$_SESSION['admin']) {
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
						<h1 class="mt-4">Tambah Berita</h1>


						<div class="card mb-4">
							<div class="card-header">
								<i class="fas fa-table me-1"></i>
								Isi Data Berita
							</div>
							<div class="card-body">
								<div class="clearfix"></div>
								<div class="row">
									<div class="col-md-12 col-sm-12 ">
										<div class="x_panel">
											<div class="x_title">

												<ul class="nav navbar-right panel_toolbox">
													<li><a href="berita.php" class="btn btn-warning">Daftar Berita</a>
													</li>
												</ul>
												<div class="clearfix"></div>
											</div>

											<div class="x_content">
												<br />
												<form class="form-horizontal form-label-left" method="POST" action="../controllers/proses_tbh_berita.php" enctype="multipart/form-data">

													<div class="form-group row ">
														<label class="control-label col-md-3 col-sm-3 ">Judul<span class="required">*</span></label>
														<div class="col-md-9 col-sm-9 ">
															<input type="text" class="form-control" id="autocomplete-custom-append" name="judul_berita" placeholder="Judul " required="required">
														</div>
													</div>
													<div class="form-group row ">
														<label class="control-label col-md-3 col-sm-3 ">Pilih Kategori<span class="required">*</span></label>
														<div class="col-md-9 col-sm-9 ">
															<select name="kategori">
																<option>Select Kategori</option>
																<?php
																$kat = mysqli_query($db, "select*from kategori");
																while ($k = mysqli_fetch_array($kat)) {
																?>
																	<option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>
													<div class="form-group row ">
														<label class="control-label col-md-3 col-sm-3 ">Gambar<span class="required">*</span></label>
														<div class="col-md-9 col-sm-9 ">
															<input type="file" class="form-control" id="autocomplete-custom-append" name="gambar" placeholder="Judul Berita">
														</div>
													</div>
													<div class="form-group row ">
														<label class="control-label col-md-3 col-sm-3 ">Isi Berita<span class="required">*</span></label>
														<div class="col-md-9 col-sm-9 ">
															<textarea class="form-control" id="autocomplete-custom-append" name="isi_berita" placeholder="Isi Berita" required="required"></textarea>
														</div>
													</div>





													<br /><br />
													<div class="form-group">
														<div class="col-md-9 col-sm-9  offset-md-3">

															<a href=""><button type="reset" class="btn btn-primary">Reset</button></a>
															<input type="submit" name="tambah" class="btn btn-success" value="Simpan" />
														</div>
													</div>

												</form>
											</div>

										</div>
									</div>
								</div>
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
} else {
?>
	<script language="javascript">
		window.location = "login.php"
	</script>
<?php
}
?>