<?php
session_start();
include_once "db.php";
include_once "fn.php";
$Q = new CRUD();  
if(empty($_SESSION['KOS_STATUS'])) {
	if(empty($_POST['username']) AND empty($_POST['password'])) {
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
        						<p>Username dan Password harus diisi. Silahkan Login kembali
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
			</div>
		', "warning");
	} else if(empty($_POST['username'])) {
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
        						<p>Username harus diisi. Silahkan Login kembali
        						</p>
        					</div>
        				</div>
        				<!--END Body-->
        					
        			</div>
        			<!--END Content-->

        		</div>
			</div>
		', "warning");
	} else if(empty($_POST['password'])) {
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
        						<p>Password harus diisi. Silahkan Login kembali
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
        							<p>Username yang anda gunakan belum terdaftar. Silahkan Login kembali
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
			if($user["password"] == md5($_POST['password'])) {
				$_SESSION['KOS_STATUS'] = TRUE;
				$_SESSION['KOS_ID'] = $user['id'];
				$_SESSION['KOS_LEVEL'] = $user['level'];
				if($user['level'] == 'admin') {
					header('Location: admin/index.php');
					exit();
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
        								<p>Password anda salah. Silahkan Login kembali
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
		}
	} 	
}
header('Location: index.php');
exit();
?>