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
$kosong=" ";

if(@$_POST['edit']){
	$move=move_uploaded_file(@$_FILES['gambar']['tmp_name'], $lokasi);
		if($move){
		$sql ="update berita set judul_berita='".$judul_berita."',kode_kategori='".$kategori."', isi_berita='".$isi_berita."', tanggal_berita='".$date."', gambar_berita='".$gambar."' where id_berita='".@$_GET['id_berita']."'";
		
		unlink($namafolder .@$_GET['gambar_berita']);
		mysqli_query($db,$sql);
		echo '<script language="javascript">  
	 window.location="../admin/berita.php?page=edit";
	 </script>';
	 	
			
	}else{

		$sql ="update berita set judul_berita='".$judul_berita."', kode_kategori='".$kategori."', isi_berita='".$isi_berita."', tanggal_berita='".$date."' where id_berita='".@$_GET['id_berita']."'";
		
			mysqli_query($db,$sql);
		echo '<script language="javascript">  
	 window.location="../admin/berita.php??page=edit";
	 </script>';
		
		
	}
}

