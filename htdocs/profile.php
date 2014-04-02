<?php 
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 
	
	$general->loggedOutProtect();
	$general->errors();

	try {
		// If id isn't in the URL OR the id is is not an integer and not greater than or equal to 1, throw error
		if (!isset($_GET["id"]) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			throw new Exception('An invalid page ID was provided to this page.');
		}

		if (isset($_GET['usertype'])) {
			$userType = $_GET['usertype'];
		}else {
			throw new Exception('A user type was not set.');
			$userType = NULL;
		}

		$id = intval($_GET["id"]);
		$status = $_GET["status"];

		switch ($userType) {
			case "designer":
				$section = "Designers";
				$general->loggedOutProtect();
				break;
			case "developer":
				$section = "Developers";
				$general->loggedOutProtect();
				break;
			case "employer":
				$section = "Employers";
				$jobs = $employers->getEmployerJobs($id);
				$general->loggedOutProtect();
				break;
			default:
				$template = "index/index.html";
				$pageTitle = "Connectd";
				$pageType = "Home";
				$section = "Home";
				$general->loggedInProtect();
				break;
		}

		if($userType == "developer" || $userType == "designer") {
			$user = $freelancers->getFreelancersSingle($id, $userType);		
			$pageTitle  = $user['firstname'] . ' ' . $user['lastname'] . ' :: ' . $user['jobtitle'];
			$template = "freelancer/freelancer-profile.html";
		} else if ($userType == "employer") {
			$user = $employers->getEmployersSingle($id);		
			$pageTitle  = $employer['employer_name'] . ' :: ' . $employer['employer_type'];
			$template = "employer/employer-profile.html";
		}

		include_once(ROOT_PATH . "includes/header.inc.php");
		include_once(ROOT_PATH . "views/" . $template);
		include_once(ROOT_PATH . "includes/footer.inc.php");

	}catch(Exception $e) {
		$general = new General($db);
		$general->errorView($general, $e);
	}
?>
