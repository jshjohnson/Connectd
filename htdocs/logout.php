<?php 
	require_once("config.php");  
	require(ROOT_PATH . "core/init.php");

	if($users->loggedIn() == true) {
		$users->doLogout();
	}else{
		header("Location:". BASE_URL);
	}
?>