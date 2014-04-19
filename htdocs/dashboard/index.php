<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();
	$users->loggedOutProtect();
	// $votes->userVotedForProtect();

	$starredBy = $_SESSION['user_id'];

	$designers    = $freelancers->getFreelancersRecent($userType = "designer");
	$developers   = $freelancers->getFreelancersRecent($userType = "developer");
	$employers    = $employers->getEmployersRecent($userType = "employer");

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	$pageTitle    = "Dashboard";
	$section      = "Dashboard";

	include(ROOT_PATH . "includes/header.inc.php");

	if($sessionUserType == 'employer') {
		$starredFreelancers = $stars->getStarredFreelancers($starredBy);
		$jobs = $jobs->getEmployerJobs($sessionUserID);
		include(ROOT_PATH . "views/dashboard/employer-dashboard.html");
	} else {
		$jobs = $jobs->getJobsAll();
		$developerJobTitles = $freelancers->getFreelancerJobTitles("developer");
		$designerJobTitles = $freelancers->getFreelancerJobTitles("designer");
		include(ROOT_PATH . "views/dashboard/freelancer-dashboard.html");
	}

	include(ROOT_PATH . "includes/footer.inc.php");
?>
