<?php
/**
 * 
 */
class FN {
	
	function __construct() { }

	public function set_message($message="", $type="") {
		if(!empty($message)) { 
			$_SESSION['_KOS_MESSAGE_'] = "<div class='{$type}'>{$message}</div>";
		} 
	}

	public function show_message() {
		if(isset($_SESSION['_KOS_MESSAGE_'])) { 
			echo $_SESSION['_KOS_MESSAGE_'];
			unset($_SESSION['_KOS_MESSAGE_']);
		} 
	}

	static public function show_notif($message="", $type="") {
		if(!empty($message)) { 
			return "<div class='{$type}'>{$message}</div>";
		} 
	}

}
?>
