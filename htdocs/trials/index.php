<?php 	
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();
	// $votes->userVotedForProtect();
	$votedBy        = $_SESSION['user_id'];

	$pageTitle      = "Trials";
	$section        = "Trials";

	$status         = $_GET["status"];

	$trial_users 	= $trials->getTrialUsers();

	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/trials.html");
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>