<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	try {
		// If id isn't in the URL OR the id is is not an integer and not greater than or equal to 1, throw error
		if (!isset($_GET["job_id"]) || !filter_var($_GET['job_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			throw new Exception('An invalid page ID was provided to this page.');
		}

		$jobID = intval($_GET['job_id']);
	
		if($jobID != '' && is_numeric($jobID)) {
			$jobs->deleteJob($jobID);
		}
	}catch(Exception $e) {
		$users = new Users($db);
		$debug = new Errors();
		$debug->errorView($users, $e);	
	}
?>