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

		$designer_id = intval($_GET["id"]);
		$designer = $designers->get_designers_single($designer_id);

		if($designer) {
			$pageTitle  = $designer['firstname'] . ' ' . $designer['lastname'] . ' :: ' . $designer['jobtitle'];
			$section    = "Designers";

			include_once(ROOT_PATH . "includes/header.inc.php");
			include_once(ROOT_PATH . "views/freelancer/designer/designer-profile.html");
			include_once(ROOT_PATH . "includes/footer.inc.php");
			
		} else {
			throw new Exception('An invalid page ID was provided to this page.');
		}

	}catch(Exception $e) {
		$general = new General($db);
		$general->errorView($general, $e);
	}
?>
