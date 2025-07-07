<?php
@SESSION_START();
include "connect.php";

if (isset($_GET['username']) )
{
	$username = @$_GET['username'];
	$password = @$_GET['password'];
	$level= @$_POST['level_user'];
   	$isi_form="username=$username";
}

if($username!='' && $password!='')
{				
	$sql_admin=mysqli_query($db, "select*from users where username='$username' and password='$password' ");
	$data_admin=mysqli_fetch_array($sql_admin);
	$cek_admin=mysqli_num_rows($sql_admin);
								
	if($cek_admin >= 1 ){
		if($data_admin['level_user'] == "admin")
		{
			@$_SESSION['admin']=$data_admin['id_user'];
			
?>
			<script language="javascript"> 
				alert("Selamat Datang <?= $data_admin['nama_user']?> \n Anda Login sebagai Admin."); 
	 			window.location="../admin/index.php";  
 			</script>;
<?php
			
		}
	}
	else
	{
		if($username != $data_admin['username'])
		{
								
?>
			<script type="text/javascript">
	        	window.location="../admin/login.php?notif=username&<?php echo $isi_form;?>";
	        </script>
                                
<?php
		}
		else if($password != $data_admin['password'])
		{
?>
            <script type="text/javascript">
				window.location="../admin/login.php?notif=password&<?php echo $isi_form;?>";
	        </script>
<?php
		}
							
	}
							
}

?>