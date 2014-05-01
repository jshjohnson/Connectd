<?php 
	require("config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	// $votes->userVotedForProtect();
	$user_id = $_GET['user_id'];
	$starredBy = $_SESSION['user_id'];

	if($user_id != '' && is_numeric($user_id)) {
		$stars->removeStar($user_id, $starredBy);
	}
?>