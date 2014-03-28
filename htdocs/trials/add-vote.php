<?php 
	require_once("../config/config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	// $votes->userVotedForProtect();
	$user_id = $_GET['user_id'];
	$votedBy = $_SESSION['user_id'];

	if($user_id != '' && is_numeric($user_id)) {
		$votes->addVote($user_id, $votedBy);
	}
?>