<?php 	
	require("../config.php");
	require(ROOT_PATH . "core/init.php");
	
	$debug->showErrors();
	$users->loggedOutProtect();

	$pageTitle = "Search";
	$section = "Navy";

	$searchTerm = "";

	if(isset($_GET['search'])) {
		$searchTerm = trim($_GET['search']);
		if($searchTerm != "") {
			if($sessionUserType == "employer") {
				$allFreelancers = $search->getFreelancersSearch($searchTerm, $sessionUserID);
			} else {
				$allJobs = $search->getJobsSearch($searchTerm);
				// $allEmployers = $search->getEmployersSearch($searchTerm);
			}
		}
	}

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/search/search.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>	