<?php
session_start();
include_once "db.php";
include_once "fn.php";
$Q = new CRUD();
if(empty($_SESSION['KOS_STATUS'])) {
	if(empty($_POST['username']) OR empty($_POST['password']) OR empty($_POST['nama'])) {
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
        						<p>Data Harus Diisi Dengan Lengkap. Silahkan register kembali
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
		$user = $Q->select()
				  ->where(["username = '$_POST[username]'"])
				  ->one("user"); 
		if(empty($user)) { 
			$temp = [
				'username' => $_POST['username'],
				'password' => md5($_POST['password']),
				'level'	   => 'pemilik_kos',
				'nama'	   => $_POST['nama'], 
			];
			unset($_POST);
			$_POST['user'] = $temp;
			$user = $Q->insert('user');
			if($user === TRUE) {
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
        								<p>Terimakasih telah mendaftar. Silahkan login untuk mengelola kost anda
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
				(new FN)->set_message($user, "error");
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
        						<p>Username sudah digunakan,silahkan gunakan username lain.</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
			</div>
		', "warning");
		}
	} 	
}
header('Location: index.php');
?>