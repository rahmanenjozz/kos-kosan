<?php
session_start();
if(isset($_SESSION['KOS_STATUS'])) {
	define('BASEURL', 'http://127.0.0.1/kosnew4');
	include_once "db.php";
	include_once "fn.php";
	$Q = new CRUD(); 
	$QW = new CRUD(); 
	$kos = $Q->select()
			 ->where(["id_user = '$_SESSION[KOS_ID]'"])
			 ->get("kos");
	$user = $QW->select()
			 ->where(["id = '$_SESSION[KOS_ID]'"])
			 ->one("user");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Info Kosan - Manajemen Kost</title>
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

	<?php (new FN)->show_message(); ?>

	<div popup_map>
		<button class="btn btn-danger btn-sm" bClose>Tutup</button>
		<div id="map"></div>
	</div>
	
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
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Beranda <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav nav-flex-icons">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Selamat Datang : <?= $user["nama"]; ?>  </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="bodata.php">Profil Saya</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Kosan <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Keluar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- END Main Navigation-->

    <nav class="breadcrumb container" style="margin-top: 100px; margin-bottom: 35px;">
        <strong>Beranda / Kosan </strong>
    </nav>

    <!-- Table with panel -->
	<div class="card card-cascade narrower container" style="margin-bottom: 100px; position: unset;">

    	<!--Card image-->
    	<div class="view view-cascade gradient-card-header success-color narrower py-2 mb-3 d-flex justify-content-between align-items-center" style="position: unset;">
    		<div style="margin-left: 20px;">
    			<button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2" style="position: unset;"><a href="tambah_kos.php" style="color: white">
                	<i class="fa fa-pencil mt-0" style="position: unset;"></i> Tambah Kosan</a>
            	</button>
    		</div>
    		<a href="" class="white-text mx-3">Data Kosan </a>
    	</div>
    	<!--/Card image-->

    	<div class="px-4">
    		<div class="table-wrapper">

    			<!--Table-->
            	<table class="table table-hover mb-0 w-auto">

                	<!--Table head-->
                	<thead>
                    	<tr>
                        	<th>#</th>
                        	<th class="th-lg"><a>Nama Kosan</a></th>
                        	<th class="th-lg"><a>Alamat</a></th>
                        	<th class="th-lg"><a>Harga</a></th>
                        	<th class="th-lg"><a>Periode</a></th>
                        	<th class="th-lg"><a>Lokasi</a></th>
                        	<th colspan="2" class="th-lg"><a>Aksi</a></th>
                    	</tr>
                	</thead>
                	<!--Table head-->

                	<!--Table body-->
                	<tbody>

                		<?php
                		if(empty($kos)){
                			echo "<tr>";
                			echo " <td colspan='7' align='center'>".FN::show_notif('Belum ada data','info')."</td>";
                			echo "</tr>";
                		} else {
                			foreach ($kos as $key => $value){
                				echo "<tr>";
                				echo " <td>".($key+1)."</td>";
                				echo " <td>$value[nama]</td>";
                				echo " <td>$value[alamat]</td>";
                				echo " <td>".number_format($value['harga'], 0, '','.')."</td>";
                				echo " <td>@".$value['periode_sewa']."</td>";
                				echo " <td>";
                					if(!empty($value['latitude']) AND !empty($value['longitude'])) {
                						echo "<button class='btn btn-info btn-sm' style='position: unset;' lihat='$value[latitude]|$value[longitude]'>Lihat</button>";
                					}
                				echo " </td>";
                				echo " <td><button class='btn btn-amber btn-sm' style='position: unset;'><a href='ubah_kos.php?id=$value[id]' style='color: white;'>Ubah</a></button></td>";
                				echo " <td><button class='btn btn-danger btn-sm' style='position: unset;'><a href='hapus_kos.php?id=$value[id]' style='color: white;'>Hapus</a></button></td>";
                				echo "<tr>";
                			}
                		}
                		?>

                	</tbody>
                	<!--Table body-->

            	</table>
           		<!--Table-->

        	</div>
    	</div>
	</div>
	<!-- Table with panel -->

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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFRvhWTrpE77H0fo7hD4Ie5c1Ed8Uy3gM" ></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <!-- Show Triger Custom Javascript -->
    <script> $('#peringatan').modal('show');</script>
    <script> $('#sukses').modal('show');</script>

    <!--  Custom Javascript -->
    <script type="text/javascript">
		$(document).ready(function() {
			$('[lihat]').click(function() {
				$('[popup_map] #map').html('');
				var c = $(this).attr('lihat');
				if(c != '') { 
					c = c.split('|');
					var lat = parseFloat(c[0]);
					var lng = parseFloat(c[1]);
					initMap(lat, lng);
					$('[popup_map]').show();
				} 
			});
			$('[popup_map] [bClose]').click(function() {
				$('[popup_map]').hide();
				$('[popup_map] #map').html('');
			});
		});
		function initMap(lat, lng) {
	        var custom_position = {lat: lat, lng: lng};   
	        var map = new google.maps.Map(document.getElementById('map'), {
	          zoom: 13,
	          center: custom_position
	        });
	        marker = new google.maps.Marker({
	          position: custom_position,
	          map: map
	        });  
	    } 
		</script>    
</body>
</html>
<?php
} else {
	header('Location: index.php');
}
?>