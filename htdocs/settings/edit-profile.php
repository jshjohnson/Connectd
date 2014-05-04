<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	
	$users->loggedOutProtect();

	try {

		$userType = $sessionUserType;
		$pageID = $sessionUserID;
		$pageTitle = "Edit Profile";

		switch ($userType) {
			case "designer":
				$pageType = "profile";
				$section = "Designer";
				$users->loggedOutProtect();
				break;
			case "developer":
				$pageType = "profile";
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

		if(empty($_POST) === false) {

			$skills = explode(',', $_POST['skills']);

			$testimonial = trim($_POST['testimonial']);
			$testimonialSource = trim($_POST['testimonial-source']);

			// If Testimonial is not empty but source is
			if(!empty($testimonial) && empty($testimonialSource)) {
				$errors[] = "You must specify the source of your testimonial";
			}

			// // If less than 3 skills are set
			// if(is_array($skills) && !empty($skills) && count($skills) < 3) {
			// 	$errors[] = "You must specify at least 3 skills";
			// }


			if(empty($errors) === true) {

				$users->removeSkills($sessionUserID);
				
				foreach($skills as $skill) {
					$users->updateSkills($skill, $sessionUserID); 
				} 

				$users->updateTestimonial($testimonial, $testimonialSource, $sessionUserID); 
				header('Location: ' . BASE_URL . 'settings/edit-profile/?success');
				exit();
			}
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
