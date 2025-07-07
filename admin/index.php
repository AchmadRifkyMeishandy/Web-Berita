<?php
	@session_start();
	include '../controllers/connect.php';
	if(@$_SESSION['admin']){
?>
!
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
                        <h1 class="mt-4">Dashboard</h1>
                        
                        
                       
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Biografi
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
<style>
    body{
        background-color: blue;
    }
</style>
                                    <tbody>
                                        <tr>
                                            <td>Berita Indonesia adalah berita seputar jakarta yang berisi berita seputar jakarta mulai dari politik sosial, dan budaya
                                                <br />
                                                Pemilik Web Berita Indonesia Adalah Achmad Rifky Meishandy, yang bertempat tinggal di Jakarta
                                            </td>
                                        </tr>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
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