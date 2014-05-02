<?php 
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	
	$users->loggedOutProtect();

	try {
		if (isset($_GET["id"])) {
			$pageID = intval($_GET["id"]);
		}
		
		if (isset($_GET['usertype'])) {
			$userType = $_GET['usertype'];
		}else {
			throw new Exception('A user type was not set.');
			$userType = NULL;
		}

		$userExists = $users->userType($pageID);
		$profileUserType = $userExists['user_type'];
		$profileUserInfo = $users->fetchInfo("granted_access", "user_id", $pageID);

		// If id isn't in the URL OR the id is is not an integer and not greater than or equal to 1, throw error
		if (!filter_var($pageID, FILTER_VALIDATE_INT, array('min_range' => 1))) {
			throw new Exception('Uh oh! An invalid page ID was provided to this page.');
		} else if($profileUserType != $userType){
			throw new Exception('Uh oh! This user has does not exist.');
		} else if($profileUserInfo == 0) {
			throw new Exception('Uh oh! That user has not been voted into the Connectd community yet.');
		}

		$status = $_GET["status"];
		$starredBy = $_SESSION['user_id'];

		switch ($userType) {
			case "designer":
				$section = "Designer";
				$pageType = "Custom";
				$section = "Designer";
				$users->loggedOutProtect();
				break;
			case "developer":
				$section = "Developer";
				$pageType = "Custom";
				$section = "Developer";
				$users->loggedOutProtect();
				break;
			case "employer":
				$section = "Employer";
				$pageType = "Custom";
				$section = "Employer";
				$jobs = $jobs->getEmployerJobs($pageID);
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
			$user = $freelancers->getFreelancersSingle($pageID, $userType);		
			$pageTitle  = ucwords($user['firstname']) . ' ' . ucwords($user['lastname']) . ' :: ' . $user['jobtitle'];
			$_SESSION["userFirstName"] = $user['firstname'];
			$_SESSION["userEmail"] = $user['email'];
			$template = "freelancer/freelancer-profile.html";
		} else if ($userType == "employer") {
			$user = $employers->getEmployersSingle($pageID);
			$employerName = ucwords($user['employer_name']);	
			$pageTitle  = $employerName . ' :: ' . $user['employer_type'];
			$template = "employer/employer-profile.html";
		}

		include(ROOT_PATH . "includes/header.inc.php");
		include(ROOT_PATH . "views/" . $template);
		include(ROOT_PATH . "includes/footer.inc.php");

	}catch(Exception $e) {
		$users = new Users($db);
		$debug = new Errors();
		$debug->errorView($users, $e);	
	}
?>
