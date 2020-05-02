<?php
session_start();
if(isset($_SESSION['KOS_STATUS'])) {
	if(isset($_GET['id'])) {
		include_once "db.php";
		include_once "fn.php";
		$Q = new CRUD();
		$user = $Q->select()
				  ->where(["id = '$_SESSION[KOS_ID]'"])
				  ->one("user");
		if(isset($_POST)) {
			if(empty($_POST['nama']) OR empty($_POST['alamat'])) {
				(new FN)->set_message('
					<div class="modal fade" id="peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-notify modal-warning modal-sm" role="document">

					<!--Content-->
					<div class="modal-content">

						<!--Header-->
						<div class="modal-header">
							<p class="heading lead">Warning</p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white-text">&times;</span>
            				</button>
        				</div>
        				<!--END Header-->

        				<!--Body-->
        				<div class="modal-body">
        					<div class="text-center">
        						<p>Data Harus Diisi Dengan Lengkap. Silahkan Periksa Kembali
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
				</div>
				', "warning");
			} else if(empty($_POST['harga'])) {
				(new FN)->set_message('
					<div class="modal fade" id="peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-notify modal-warning modal-sm" role="document">

					<!--Content-->
					<div class="modal-content">

						<!--Header-->
						<div class="modal-header">
							<p class="heading lead">Warning</p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white-text">&times;</span>
            				</button>
        				</div>
        				<!--END Header-->

        				<!--Body-->
        				<div class="modal-body">
        					<div class="text-center">
        						<p>Harga Harus Diisi. Silahkan Periksa Kembali
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
				</div>
				', "warning");
			} else if(empty($_POST['periode_sewa'])) {
				(new FN)->set_message('
					<div class="modal fade" id="peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-notify modal-warning modal-sm" role="document">

					<!--Content-->
					<div class="modal-content">

						<!--Header-->
						<div class="modal-header">
							<p class="heading lead">Warning</p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white-text">&times;</span>
            				</button>
        				</div>
        				<!--END Header-->

        				<!--Body-->
        				<div class="modal-body">
        					<div class="text-center">
        						<p>Periode Sewa Harus Diisi. Silahkan Periksa Kembali
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
				</div>
				', "warning");
			} else {
				if(empty($_POST['latitude']) OR empty($_POST['longitude']) OR empty($_POST['alamat_map'])) {
					(new FN)->set_message('<div class="modal fade" id="peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-notify modal-warning modal-sm" role="document">

					<!--Content-->
					<div class="modal-content">

						<!--Header-->
						<div class="modal-header">
							<p class="heading lead">Warning</p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white-text">&times;</span>
            				</button>
        				</div>
        				<!--END Header-->

        				<!--Body-->
        				<div class="modal-body">
        					<div class="text-center">
        						<p>Periode Sewa Harus Diisi. Silahkan Periksa Kembali
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
				</div>
				', "warning");
				} else {
					$images = [];
					$path   = "gambar_kos".DIRECTORY_SEPARATOR; 
					foreach ($_FILES['gambar']['name'] as $key => $value) {
						$cek_gambar = getimagesize($_FILES["gambar"]["tmp_name"][$key]);
						if($cek_gambar !== FALSE) {
							$filename = explode(".", $value);
							$filename = $filename[count($filename)-1];
							$filename = date('YmdHis').rand().".".$filename;
							if (move_uploaded_file($_FILES["gambar"]["tmp_name"][$key], $path.$filename)) {
						        $images[] = $filename;
						    } 
						} 
					} 
					$images = empty($images) ? "":implode(";", $images); 
					$temp = [
						'nama' 		=> $_POST['nama'],
						'alamat' 	=> $_POST['alamat'],
						'gambar'	=> $images,
						'latitude'	=> $_POST['latitude'], 
						'longitude'	=> $_POST['longitude'], 
						'alamat_map'=> $_POST['alamat_map'], 
						'harga'		=> $_POST['harga'], 
						'periode_sewa'=> $_POST['periode_sewa'], 
						'id_user'	=> $user['id']
					]; 
					unset($_POST);
					$_POST['kos'] = $temp;
					$_POST['_id'] = $_GET['id'];
					$kos = $Q->update('kos');
					if($kos === TRUE) {
						(new FN)->set_message('
							<div class="modal fade" id="peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-notify modal-success modal-sm" role="document">

							<!--Content-->
							<div class="modal-content">

								<!--Header-->
								<div class="modal-header">
									<p class="heading lead">Success</p>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" class="white-text">&times;</span>
            						</button>
        						</div>
        						<!--END Header-->

        						<!--Body-->
        						<div class="modal-body">
        							<div class="text-center">
        								<p>Kos berhasil disimpan
        								</p>
        							</div>
        						</div>
        						<!--END Body-->
        					
        					</div>
        					<!--END Content-->

        				</div>
					</div>
					', "success");
					} else {
						(new FN)->set_message($kos, "error");
					}
				}   
			} 	
		} else {
			(new FN)->set_message('
				<div class="modal fade" id="peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-notify modal-warning modal-sm" role="document">

					<!--Content-->
					<div class="modal-content">

						<!--Header-->
						<div class="modal-header">
							<p class="heading lead">Warning</p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white-text">&times;</span>
            				</button>
        				</div>
        				<!--END Header-->

        				<!--Body-->
        				<div class="modal-body">
        					<div class="text-center">
        						<p>Form harus diisi semua. Silahkan Periksa Kembali
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
				</div>
			', "warning");
		}
		header('Location: ubah_kos.php?id='.$_GET["id"]);
	} else {
		(new FN)->set_message('
			<div class="modal fade" id="peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-notify modal-warning modal-sm" role="document">

					<!--Content-->
					<div class="modal-content">

						<!--Header-->
						<div class="modal-header">
							<p class="heading lead">Warning</p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white-text">&times;</span>
            				</button>
        				</div>
        				<!--END Header-->

        				<!--Body-->
        				<div class="modal-body">
        					<div class="text-center">
        						<p>Tidak ada perintah
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
				</div>
		', "warning");
		header('Location: kos.php');
	}  
} else {
	header('Location: index.php');
}
?>