<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();

	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	$pageTitle = "Dashboard";
	$pageType = "Custom";
	$section = "Navy";

	$starredBy = $_SESSION['user_id'];

	$designers = $freelancers->getFreelancersRecent($userType = "designer");
	$developers = $freelancers->getFreelancersRecent($userType = "developer");

	$starredFreelancers = $stars->getStarredFreelancers($starredBy);

	$allFreelancers = $freelancers->getFreelancersAllTypes($sessionUserID);

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	if($sessionUserType == 'employer') {
		$allJobs = $jobs->getEmployerJobs($sessionUserID);
		$template = "employer-dashboard.html";
	} else {
		$recentJobs = $jobs->getJobsRecent();
		$recentEmployers = $employers->getEmployersRecent();
		$starredEmployers = $stars->getStarredEmployers($starredBy);
		$template = "freelancer-dashboard.html";
	}

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/dashboard/" . $template);
	include(ROOT_PATH . "includes/footer.inc.php");
?>
