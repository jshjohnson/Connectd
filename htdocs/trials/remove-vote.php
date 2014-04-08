<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$debug->showErrors();
	// $votes->userVotedForProtect();
	$user_id = $_GET['user_id'];
	$votedBy = $_SESSION['user_id'];

	if($user_id != '' && is_numeric($user_id)) {
		$votes->removeVote($user_id, $votedBy);
	}
?>