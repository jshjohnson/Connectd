<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 
	
	$general->loggedOutProtect();
	$general->errors();

	try {
		// If id isn't in the URL OR the id is is not an integer and not greater than or equal to 1, throw error
		if (!isset($_GET["id"]) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			throw new Exception('An invalid page ID was provided to this page.');
		}

		$job_id = intval($_GET["id"]);
		$job = $jobs->get_jobs_single($job_id);

		if($job) {
			$pageTitle  = $job['job_name'] . ' :: ' . $job['employer_name'];
			$section    = "Employers";

			include_once(ROOT_PATH . "includes/header.inc.php");
			include_once(ROOT_PATH . "views/job/job-profile.html");
			include_once(ROOT_PATH . "includes/footer.inc.php");
		} else {
			throw new Exception('An invalid page ID was provided to this page.');
		}

	}catch(Exception $e) {
		$general = new General($db);
		$general->errorView($general, $e);
	}
?>


