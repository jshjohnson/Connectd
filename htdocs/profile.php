<?php 
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 
	
	$users->loggedOutProtect();
	$debug->showErrors();

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
				$users->loggedOutProtect();
				break;
			case "developer":
				$section = "Developers";
				$users->loggedOutProtect();
				break;
			case "employer":
				$section = "Employers";
				$jobs = $employers->getEmployerJobs($id);
				$users->loggedOutProtect();
				break;
			default:
				$template = "index/index.html";
				$pageTitle = "Connectd";
				$pageType = "Home";
				$section = "Home";
				$users->loggedInProtect();
				break;
		}

		if($userType == "developer" || $userType == "designer") {
			$user = $freelancers->getFreelancersSingle($id, $userType);		
			$pageTitle  = $user['firstname'] . ' ' . $user['lastname'] . ' :: ' . $user['jobtitle'];
			$_SESSION["userFirstName"] = $user['firstname'];
			$_SESSION["userEmail"] = $user['email'];
			$template = "freelancer/freelancer-profile.html";
		} else if ($userType == "employer") {
			$user = $employers->getEmployersSingle($id);
			$employerName = $user['employer_name'];	
			$pageTitle  = $employerName . ' :: ' . $user['employer_type'];
			$template = "employer/employer-profile.html";
		}

		include_once(ROOT_PATH . "includes/header.inc.php");
		include_once(ROOT_PATH . "views/" . $template);
		include_once(ROOT_PATH . "includes/footer.inc.php");

	}catch(Exception $e) {
		$users = new Users($db);
		$general = new General();
		$errors->errorView($users, $general, $e);
	}
?>
