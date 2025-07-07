<?php
@session_start();
include "connect.php";

$nama_kategori=@$_POST['nama_kategori'];
$date=date('d F Y');
		

if(@$_POST['tambah']){

	$sql ="insert into kategori(nama_kategori,tanggal_kategori) values('".$nama_kategori."','".$date."')";
	mysqli_query($db,$sql);
	echo '<script language="javascript">  
 window.location="../admin/kategori.php?page=simpan"
 </script>';
}

