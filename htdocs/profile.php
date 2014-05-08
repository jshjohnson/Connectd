<?php 
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	
	try {
		if (isset($_GET["id"])) {
			$userID = intval($_GET["id"]);
		}
		
		if (isset($_GET['usertype'])) {
			$userType = $_GET['usertype'];
		}else {
			throw new Exception('A user type was not set.');
			$userType = NULL;
		}

		$userExists = $users->userType($userID);
		$profileUserType = $userExists['user_type'];
		$profileUserInfo = $users->fetchInfo("granted_access", "user_id", $userID);

		if (!filter_var($userID, FILTER_VALIDATE_INT, array('min_range' => 1))) {
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
				$designerSkills = $freelancers->getFreelancerSkills($userID);
				break;
			case "developer":
				$section = "Developer";
				$pageType = "Custom";
				$section = "Developer";
				$developerSkills = $freelancers->getFreelancerSkills($userID);
				break;
			case "employer":
				$section = "Employer";
				$pageType = "Custom";
				$section = "Employer";
				$allJobs = $jobs->getEmployerJobs($userID);
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
			$user = $freelancers->getFreelancersSingle($userID, $userType);
			$portfolioPieces = $freelancers->getFreelancerPortfolio($userID);
			$testimonial = stripslashes($user['testimonial']);
			$testimonialSource = $user['testimonial_source'];

			$pageTitle  = ucwords($user['firstname']) . ' ' . ucwords($user['lastname']) . ' :: ' . $user['jobtitle'];
			$_SESSION["userFirstName"] = $user['firstname'];
			$_SESSION["userEmail"] = $user['email'];
			$template = "freelancer/freelancer-profile.html";
		} else if ($userType == "employer") {
			$user = $employers->getEmployersSingle($userID);
			$starredAvatars = $stars->getUserStars($userID);
			$employerName = ucwords($user['employer_name']);	
			$pageTitle  = $employerName . ' :: ' . $user['employer_type'];
			$template = "employer/employer-profile.html";
		}

		$userAvatar = $user['image_location'];
		$bio = $urls->twitterLinks($user['bio']);

		include(ROOT_PATH . "includes/header.inc.php");
		include(ROOT_PATH . "views/" . $template);
		include(ROOT_PATH . "includes/footer.inc.php");

	}catch(Exception $e) {
		$users = new Users($db);
		$debug = new Errors();
		$debug->errorView($users, $e);	
	}
?>
