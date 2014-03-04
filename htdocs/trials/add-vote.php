<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$user_id = $_GET["user_id"];
	
	$general->addVote($user_id);
?>