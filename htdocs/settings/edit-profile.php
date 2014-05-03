<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	
	$users->loggedOutProtect();

	try {

		$userType = $sessionUserType;
		$pageID = $sessionUserID;

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
			$template = "settings/edit-profile.html";
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
