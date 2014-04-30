<?php 
	require("config.php"); 
	require(ROOT_PATH . "core/init.php");

	if (isset($_GET['user_id'])) {
		$userID = $_GET['user_id'];
	}
	
	if($userID != '' && is_numeric($userID)) {
		$users->deleteUser($userID);
	}
?>