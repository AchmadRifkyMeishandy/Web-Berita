<?php
	@session_start();
	session_destroy();
if($_GET['page']=="admin")
{
	echo '<script language="javascript"> 
 		window.location="../admin/login.php"; 
 		</script>';
}



