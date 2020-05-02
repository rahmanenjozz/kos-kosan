<?php
session_start();
if(isset($_SESSION['KOS_STATUS'])) {
define('BASEURL', 'http://127.0.0.1/kosnew4');
include_once "db.php";
include_once "fn.php";
include_once "modal.php";
$Q = new CRUD();
$QD = new CRUD();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Info Kosan</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- jQuery -->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet"> 
</head>
<body>

    <!-- Start your project here-->

    <!--Main Navigation-->
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark primary-color scrolling-navbar">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="#"><strong>Info Kosan</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Beranda <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav nav-flex-icons">

                        <?php
                        if(isset($_SESSION['KOS_STATUS'])) {
                            $user = $QD->select()
                                    ->where(["id = '$_SESSION[KOS_ID]'"])
                                    ->get("user");
                            $user2 = $Q->select()
                                    ->where(["id = '$_SESSION[KOS_ID]'"])
                                    ->one("user");
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Selamat Datang : <?= $user2["nama"]; ?>  </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="bodata.php">Profil Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="kos.php">Kosan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Keluar</a>
                        </li>

                        <?php
                        } else {
                        ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login atau Register</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#" data-target="#login" data-toggle="modal"><i class="fa fa-sign-in mr-1"></i> Login</a> 
                                <a class="dropdown-item" href="#" data-target="#register" data-toggle="modal"><i class="fa fa-users mr-1"></i> Register</a>
                            </div>
                        </li>

                        <?php
                        } 
                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- END Main Navigation-->

    <!-- Notif -->
    <?php
    (new FN)->show_message();
    ?>
    <!-- END Notif -->

    <!-- Breadcrumb-->
    <nav class="breadcrumb container" style="margin-top: 100px; margin-bottom: 35px;">
        <strong> Beranda / Profil</span></strong>
    </nav>
    <!-- END Breadcrumb-->
    <blockquote class="blockquote bq-success container">
    <p class="bq-title">My Profil</p>
    <?php
    foreach ($user as $key => $value){
                                echo "<tr>";
                                echo " <td>Nama Lengkap </td>";
                                echo " <td>: </td>";
                                echo " <td>$value[nama]</td>";
                                echo "</tr></br>";
                                echo "<tr>";
                                echo " <td>Username </td>";
                                echo " <td>: </td>";
                                echo " <td>$value[username]</td>";
                            }
    ?>
    </blockquote>


    <!-- Footer -->
    <footer class="page-footer font-small blue" style="
    position: fixed;
    width: 100%;">
        <div class="footer-copyright text-center py-3">© 2018 Copyright: 
            <a href="#"> INFO KOSAN</a>
        </div>
    </footer>
    <!-- END Footer -->

    <!-- END Start your project here-->

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- API Google MAPS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=" ></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <!-- Show Triger Custom Javascript -->
    <script> $('#peringatan').modal('show');</script>
    <script> $('#sukses').modal('show');</script>
</body>
</html>
<?php
} else {
    header('Location: index.php');
}
?>