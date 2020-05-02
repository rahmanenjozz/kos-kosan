<?php
session_start();
include_once "db.php";
include_once "fn.php";
include("db_config.php");


		$username = addslashes(trim($_REQUEST['username']));
		$pass = $_REQUEST['password'];

		$q = "SELECT * FROM user where username='".$username."' AND password = '".md5($pass)."'" ;

		if (!mysqli_query($con,$q)) {
			die('Error: ' . mysqli_error($con));
		}

		$result = mysqli_query($con,$q);
		$row_cnt = mysqli_num_rows($result);

		if ($row_cnt > 0) {
			$row = mysqli_fetch_array($result);
			if ($row){
				$_SESSION['KOS_STATUS'] = TRUE;
				$_SESSION['KOS_ID'] = $row[0];
				$_SESSION['KOS_LEVEL'] = $row[4];
				if($user['level'] == 'admin') {
					header('Location: admin/index.php');
					exit();
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
		

header('Location: index.php');
exit();
?>