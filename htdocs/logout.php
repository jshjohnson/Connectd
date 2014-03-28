<?php 
	require_once("config/config.php");  
	require_once(ROOT_PATH . "core/init.php");

	if($general->loggedIn() == true) {
		$general->doLogout();
	}else{
		header("Location:". BASE_URL);
	}
?>