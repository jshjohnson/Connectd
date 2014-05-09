<?php 	
	require("../config.php");
	require(ROOT_PATH . "core/init.php");

	$users->loggedOutProtect();

	$pageTitle = "Search";
	$pageType = "Custom";
	$section = "Navy";

	$searchTerm = "";

	if(isset($_GET['search'])) {
		$searchTerm = trim($_GET['search']);
		if($searchTerm != "") {
				$allFreelancers = $search->getFreelancersSearch($searchTerm, $sessionUserID);
				$allEmployers = $search->getEmployersSearch($searchTerm);			
				$allJobs = $search->getJobsSearch($searchTerm);
				$allResults = count($allFreelancers . $allEmployers . $allJobs);
		}
		if($allResults <= 1) {
			$resultCount = $allResults . " result";
		} else {
			$resultCount = $allResults . " results";
		}
	}

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/search/search.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>	