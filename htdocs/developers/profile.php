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

		$developer_id = intval($_GET["id"]);
		$developer = $developers->get_developers_single($developer_id);
		$status = $_GET["status"];

		if($developer) {
			$_SESSION["userFirstName"] = $developer['firstname'];
			$_SESSION["userEmail"] = $developer['email'];

			$pageTitle = $developer['firstname'] . ' ' . $developer['lastname'] . ' :: ' . $developer['jobtitle'];
			$section = "Developers";

			include_once(ROOT_PATH . "includes/header.inc.php");
			include_once(ROOT_PATH . "views/freelancer/developer/developer-profile.html");
			include_once(ROOT_PATH . "includes/footer.inc.php");
			
		} else {
			throw new Exception('An invalid page ID was provided to this page.');
		}

	}catch(Exception $e) {
		$general = new General($db);
		$general->errorView($general, $e);
	}
?>
