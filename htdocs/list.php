<?php 
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 

	$users->loggedOutProtect();
	$debug->showErrors();

	try {

		if (isset($_GET['usertype'])) {
			$userType = $_GET['usertype'];
		}else {
			throw new Exception('A user type was not set.');
			$userType = NULL;
		}

		$status = $_GET["status"];

	switch ($userType) {
		case "designer":
			$section = "Designers";
			$users->loggedOutProtect();
			$pageTitle = "Designer list";
			break;
		case "developer":
			$section = "Developers";
			$users->loggedOutProtect();
			$pageTitle = "Developer list";
			break;
		case "employer":
			$section = "Employers";
			$users->loggedOutProtect();
			$pageTitle = "Employer list";
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
			$freelancers = $freelancers->getFreelancersAll($userType);	
			$freelancer_id = $_GET["id"];	
		} else if ($userType == "employer") {
			$employers = $employers->getEmployersAll($userType);
			$employer_id = $_GET["id"];
		}

		include_once(ROOT_PATH . "includes/header.inc.php");
		include_once(ROOT_PATH . "views/page/list.html");
		include_once(ROOT_PATH . "includes/footer.inc.php");

	}catch(Exception $e) {
		$users = new Users($db);
		$debug = new Errors();
		$debug->errorView($users, $e);	
	}
?>		