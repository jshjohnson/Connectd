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

		$employer_id = intval($_GET["id"]);
		$employer = $employers->get_employers_single($employer_id);
		$jobs = $employers->getEmployerJobs($employer_id);

		if($employer) {
			$pageTitle  = $employer['employer_name'] . ' :: ' . $employer['employer_type'];
			$section    = "Employers";

			include_once(ROOT_PATH . "includes/header.inc.php");
			include_once(ROOT_PATH . "views/employer-profile.html");
			include_once(ROOT_PATH . "includes/footer.inc.php");
			
		} else {
			throw new Exception('An invalid page ID was provided to this page.');
		}

	}catch(Exception $e) {
		$general = new General($db);
		$general->errorView($general, $e);
	}
?>

