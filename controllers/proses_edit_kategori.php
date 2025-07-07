<?php
@session_start();
include "connect.php";

$judul=@$_POST['nama_kategori'];
$date=date('d F Y');


if($_POST['edit']){
	$sql ="update kategori set nama_kategori='".$judul."', tanggal_kategori='".$date."' where id_kategori='".$_GET['id_kategori']."'";	
	mysqli_query($db,$sql);
	echo '<script language="javascript">window.location="../admin/kategori.php?page=edit"</script>';
}
?>		
		
