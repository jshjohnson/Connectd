<?php 	
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);
	
	$votedBy = $_SESSION['user_id'];

	$pageTitle = "Trials";
	$pageType = "Custom";
	$section = "Trials";

	$status = $_GET["status"];

	$trialUsers = $trials->getTrialUsers($votedBy);

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/trial/trials.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>