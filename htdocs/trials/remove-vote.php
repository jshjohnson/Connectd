<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);
	
	$user_id = $_GET['user_id'];
	$votedBy = $_SESSION['user_id'];

	if($user_id != '' && is_numeric($user_id)) {
		$votes->removeVote($user_id, $votedBy);
	}
?>