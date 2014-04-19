<?php 
	require("config.php"); 
	require(ROOT_PATH . "core/init.php");

	if (isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
	}
	
	$starredBy = $sessionUserID;

	if($user_id != '' && is_numeric($user_id)) {
		$stars->addStar($user_id, $starredBy);
	}
?>