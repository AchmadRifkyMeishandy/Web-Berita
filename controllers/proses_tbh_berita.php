<?php
@session_start();
include "connect.php";

$judul_berita=@$_POST['judul_berita'];
$isi_berita=@$_POST['isi_berita'];
$kategori=@$_POST['kategori'];
$gambar=@$_FILES['gambar']['name'];
$date=date('d F Y');

$namafolder="../images/";
$lokasi = $namafolder . basename($gambar);

if(@$_POST['tambah']){
	$move=move_uploaded_file(@$_FILES['gambar']['tmp_name'], $lokasi);
	if($move){
	$sql ="insert into berita(judul_berita,isi_berita,kode_kategori,tanggal_berita,gambar_berita) 
	values('".$judul_berita."','".$isi_berita."','".$kategori."','".$date."','".$gambar."')";
	mysqli_query($db,$sql);
	echo '<script language="javascript">  
 window.location="../admin/berita.php?page=simpan"
 </script>';
	}
}

