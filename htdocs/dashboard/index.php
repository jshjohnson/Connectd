<?php
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$debug->showErrors();
	$users->loggedOutProtect();
	// $votes->userVotedForProtect();

	$designers    = $freelancers->getFreelancersRecent($userType = "designer");
	$developers   = $freelancers->getFreelancersRecent($userType = "developer");
	$employers    = $employers->getEmployersRecent($userType = "employer");
	$jobs         = $jobs->getJobsAll();

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	$pageTitle    = "Dashboard";
	$section      = "Dashboard";

	include_once(ROOT_PATH . "includes/header.inc.php");

	if($sessionUserType == 'employer') {
		include_once(ROOT_PATH . "views/dashboard/employer-dashboard.html");
	} else {
		$developerJobTitles = $freelancers->getFreelancerJobTitles("developer");
		$designerJobTitles = $freelancers->getFreelancerJobTitles("designer");
		include_once(ROOT_PATH . "views/dashboard/freelancer-dashboard.html");
	}

	include_once(ROOT_PATH . "includes/footer.inc.php");
?>
