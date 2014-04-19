<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();
	$users->loggedOutProtect();
	// $votes->userVotedForProtect();

	$starredBy = $_SESSION['user_id'];

	$designers    = $freelancers->getFreelancersRecent($userType = "designer");
	$developers   = $freelancers->getFreelancersRecent($userType = "developer");
	$starredFreelancers = $stars->getStarredFreelancers($starredBy);
	$employers    = $employers->getEmployersRecent($userType = "employer");
	$jobs         = $jobs->getJobsAll();

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	$pageTitle    = "Dashboard";
	$section      = "Dashboard";

	include(ROOT_PATH . "includes/header.inc.php");

	if($sessionUserType == 'employer') {
		include(ROOT_PATH . "views/dashboard/employer-dashboard.html");
	} else {
		$developerJobTitles = $freelancers->getFreelancerJobTitles("developer");
		$designerJobTitles = $freelancers->getFreelancerJobTitles("designer");
		include(ROOT_PATH . "views/dashboard/freelancer-dashboard.html");
	}

	include(ROOT_PATH . "includes/footer.inc.php");
?>
