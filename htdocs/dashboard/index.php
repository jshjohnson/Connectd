<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();

	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	$starredBy = $_SESSION['user_id'];

	$designers = $freelancers->getFreelancersRecent($userType = "designer");
	$developers = $freelancers->getFreelancersRecent($userType = "developer");

	$starredFreelancers = $stars->getStarredFreelancers($starredBy);

	$allFreelancers = $freelancers->getFreelancersAllTypes($sessionUserID);

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	$pageTitle = "Dashboard";
	$pageType = "Custom";
	$section = "Navy";

	include(ROOT_PATH . "includes/header.inc.php");

	if($sessionUserType == 'employer') {
		$jobs = $jobs->getEmployerJobs($sessionUserID);
		
		include(ROOT_PATH . "views/dashboard/employer-dashboard.html");
	} else {
		$allJobs = $jobs->getJobsRecent();
		$recentEmployers = $employers->getEmployersRecent();
		include(ROOT_PATH . "views/dashboard/freelancer-dashboard.html");
	}

	include(ROOT_PATH . "includes/footer.inc.php");
?>
