<?php
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();
	// $votes->userVotedForProtect();

	$designers    = $freelancers->getFreelancersRecent($userType = "designer");
	$developers   = $freelancers->getFreelancersRecent($userType = "developer");
	$employers    = $employers->getEmployersRecent();
	$jobs         = $jobs->getJobsAll();

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	$pageTitle    = "Dashboard";
	$section      = "Dashboard";

	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/dashboard/dashboard.html");
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>
