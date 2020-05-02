<?php
session_start();
define('BASEURL', 'http://127.0.0.1/kosnew4');
include_once "db.php";
include_once "fn.php";
include_once "modal.php";
$Q = new CRUD();
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
                            <a class="nav-link" href="#">Beranda <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav nav-flex-icons">

                        <?php
                        if(isset($_SESSION['KOS_STATUS'])) {
                            $user = $Q->select()
                                    ->where(["id = '$_SESSION[KOS_ID]'"])
                                    ->one("user");
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Selamat Datang : <?= $user["nama"]; ?>  </a>
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

    <!--Jumbotron-->
    <div class="row mb-5" style="margin-right: 0px; margin-left: 0px; margin-bottom: 20px!important;">
        <div class="col-md-12" style="padding-right: 0px; padding-left: 0px;">
            <div class="card card-image" style="background-image: url(img/banner2.png); background-repeat: no-repeat; background-position: center; background-size: cover;">
                <div class="text-white text-center rgba-stylish-strong py-5 px-4">
                    <div class="py-5">
                        <h2 class="card-title pt-3 mb-5 font-bold">Cari Kosan ?</h2>
                        <p class="px-5 pb-4">Disini Info kosan Daerah Kota Bandung Lengkap, terpercaya, dan aman terkendali hanya di Info Kosan.</p>

                        <!--MAP poup-->
                        <div popup_map>
                            <button bClose>Tutup</button>
                            <div id="map"></div>
                        </div>
                        <!--MAP poup--> 

                        <!-- Search form -->
                        <form class="container">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <input type="text" class="form-control" placeholder="Nama Tempat" value="" name="search">
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" name="jarak">

                                        <?php
                                        foreach (range(1, 20) as $key => $value) {
                                            echo "<option value='$value' >Radius $value KM</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select class="form-control" name="harga">
                                        <option value="ASC">Harga Termurah</option>
                                        <option value="DESC">Harga Termahal</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <button bSearchKos  type="button" class="form-control btn btn-primary btn-md" style="margin:0;"><i class="fa fa-search mr-1"></i> Cari Kosan</button>
                                </div>
                            </div>
                        </form>
                        <!-- ENDSearch form -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Jumbotron-->

    <!-- Breadcrumb-->
    <nav class="breadcrumb container">
        <strong>Lokasi : <span lokasi_terdeteksi>-</span></strong>
    </nav>
    <!-- END Breadcrumb-->

    <hr />
    <div class="list_kos container">
        <table class="container-fluid">
            <tbody>

            </tbody>
        </table>
    </div>

    
    

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
    <!-- Custom Javascript -->
    <script type="text/javascript" src="js/config.js"></script>

    <!-- Show Triger Custom Javascript -->
    <script> $('#peringatan').modal('show');</script>
    <script> $('#sukses').modal('show');</script>
</body>
</html>
