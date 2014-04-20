<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();
	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	$starredBy = $_SESSION['user_id'];

	$designers = $freelancers->getFreelancersRecent($userType = "designer");
	$developers = $freelancers->getFreelancersRecent($userType = "developer");
	$employers = $employers->getEmployersRecent($userType = "employer");

	$starredFreelancers = $stars->getStarredFreelancers($starredBy);

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	$pageTitle    = "Dashboard";
	$section      = "Dashboard";

	include(ROOT_PATH . "includes/header.inc.php");

	if($sessionUserType == 'employer') {
		$jobs = $jobs->getEmployerJobs($sessionUserID);
		include(ROOT_PATH . "views/dashboard/employer-dashboard.html");
	} else {
		$jobs = $jobs->getJobsRecent();
		$allFreelancers = $freelancers->getFreelancersAllTypes($sessionUserID);
		include(ROOT_PATH . "views/dashboard/freelancer-dashboard.html");
	}

	include(ROOT_PATH . "includes/footer.inc.php");
?>
