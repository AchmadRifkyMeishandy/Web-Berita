<?php
@session_start();
include "connect.php";

$nama_k=@$_POST['nama_k'];
$isi_k=@$_POST['isi_k'];
$berita=@$_POST['berita'];
$date=date('d F Y');
		

if(@$_POST['tambah']){
	$sql ="insert into komentar(nama_k,isi_k,tanggal_k,kode_berita) 
    values('".$nama_k."','".$isi_k."','".$date."','".$berita."')";
	mysqli_query($db,$sql);
	echo '<script language="javascript">  
 	window.location="../admin/komentar.php?page=simpan"
 	</script>';

}
?>