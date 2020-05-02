<?php
session_start();
if(isset($_SESSION['KOS_STATUS'])) {
	include_once "db.php";
	include_once "fn.php";
	if(isset($_GET['id'])) { 
		$Q = new CRUD();
		$data = $Q->select()
				  ->where(["id = '$_GET[id]'"])
				  ->one("kos");
		if(!empty($data['gambar'])) {
			$gambar = explode(";", $data['gambar']);
			foreach ($gambar as $key => $value) {
				if(file_exists('gambar_kos/'.$value)) {
					unlink('gambar_kos/'.$value);
				}
			}  
		}
		$_POST['_id'] = $_GET['id'];
		$kos = $Q->delete('kos');
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
        								<p>Kos berhasil dihapus
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
        						<p>Tidak ada perintah !
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
	header('Location: kos.php');
} else {
	header('Location: index.php');
}
?>