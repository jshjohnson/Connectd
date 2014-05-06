<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	if (isset($_GET['user_id'])) {
		$userID = $_GET['user_id'];
	} else {
		header("Location:" . BASE_URL);
		exit();
	}
	
	if($userID != '' && is_numeric($userID)) {
		$users->deleteUser($userID);
	}
?>