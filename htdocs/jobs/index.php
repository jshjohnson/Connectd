<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	
	$users->loggedOutProtect();
	
	try {
		// If id isn't in the URL OR the id is is not an integer and not greater than or equal to 1, throw error
		if (!isset($_GET["id"]) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			throw new Exception('An invalid page ID was provided to this page.');
		}

		$jobID = intval($_GET["id"]);
		$_SESSION["job_id"] = $jobID;
		$job = $jobs->getJobsSingle($jobID);
		$userID = $job['user_id'];
		$user = $employers->getEmployersSingle($userID);
		$employerName = $user['employer_name'];

		if($job) {
			$pageTitle  = ucwords($job['job_name']) . ' :: ' . ucwords($job['employer_name']);
			$section    = "Job";

			include(ROOT_PATH . "includes/header.inc.php");
			include(ROOT_PATH . "views/job/job-profile.html");
			include(ROOT_PATH . "includes/footer.inc.php");
		} else {
			throw new Exception('An invalid page ID was provided to this page.');
		}

	}catch(Exception $e) {
		$users = new Users($db);
		$debug = new Errors();
		$debug->errorView($users, $e);	
	}
?>


