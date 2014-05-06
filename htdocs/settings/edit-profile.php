<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	
	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	try {

		$userType = $sessionUserType;
		$userID = $sessionUserID;
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
			$user = $freelancers->getFreelancersSingle($userID, $userType);
			$skills = $freelancers->getFreelancerSkills($userID);
			$userAvatar = $user['image_location'];
			$jobTitles = $freelancers->getFreelancerJobTitles($userType);
			$pageTitle  = ucwords($user['firstname']) . ' ' . ucwords($user['lastname']) . ' :: ' . $user['jobtitle'];
			$template = "settings/edit-profile.html";
		}

		if(empty($_POST) === false) {

			$jobTitle = trim($_POST['jobtitle']);
			$pricePerHour = trim($_POST['priceperhour']);
			$designerSkills = explode(',', trim($_POST['des-skills']));
			$developerSkills = $_POST['dev-skill'];
			$deletePortfolio = trim($_POST['delete-portfolio']);
			$portfolioPieces = $_FILES['portfolio-piece'];
			$testimonial = trim($_POST['testimonial']);
			$testimonialSource = trim($_POST['testimonial-source']);

			// If Testimonial is not empty but source is
			if(!empty($testimonial) && empty($testimonialSource)) {
				$errors[] = "You must specify the source of your testimonial";
			}

			if($userType == "designer") {
				if(empty($designerSkills)) {
					$errors[] = "You must specify at least one skill";
				}
			}

			if($deletePortfolio == "delete") {
				$freelancers->removePortfolioPiece($sessionUserID);
			}

			if(isset($developerSkills)) {
				foreach($developerSkills as $key => $value) {
					if(!empty($_POST['dev-skill'][$key]) && empty($_POST['dev-skill-rating'][$key])) {
						$errors[] = "You must specify a skill rating with your skill";
					}
					if(empty($errors) === true) {
						$freelancers->updateSkills($_POST['dev-skill'][$key], $_POST['dev-skill-rating'][$key], $sessionUserID);
					}
				}			
			}

			if ($_FILES['portfolio-pieces']["size"][0] > 0) {

				$freelancers->removePortfolioPiece($sessionUserID);

				// if($_FILES['portfolio-pieces']['size'] > 6) {
				// 	$errors[] = "You can only upload up to 6 portfolio pieces.";
				// }

				foreach ($_FILES['portfolio-pieces']['name'] as $key => $name) {

					$tmpName       = $_FILES['portfolio-pieces']['tmp_name'][$key];
					$allowed_ext   = array('jpg', 'jpeg', 'png', 'gif', 'svg');
					$a             = explode('.', $name);
					$fileExt       = strtolower(end($a)); unset($a);
					$fileSize      = $_FILES['portfolio-pieces']['size'][$key];
					$fileType      = $_FILES['portfolio-pieces']['type'][$key];
					$path          = "assets/portfolio-pieces";

					if (in_array($fileExt, $allowedExt) === false) {
						$errors[] = 'Image file type not allowed';	
					}	
					if ($fileSize > 2097152) {
						$errors[] = 'File size must be under 2mb';
					}

					if(empty($errors) === true) {
						$newpath = $forms->fileNewPath($path, $name);
						move_uploaded_file($tmpName, ROOT_PATH . $newpath);

						$fileLocation = htmlentities(trim($newpath));
						$freelancers->updatePortfolioPiece($fileLocation, $fileType, $sessionUserID);
					}
				}
			}

			if(empty($errors) === true) {

				if($userType == "designer" && !empty($designerSkills[0])) {
					$freelancers->removeSkills($sessionUserID);
					foreach($designerSkills as $skill) {
						$freelancers->updateSkills($skill, $skillRating, $sessionUserID); 
					}		
				}
			
				$freelancers->updateTestimonial($testimonial, $testimonialSource, $sessionUserID); 
				$freelancers->updateFreelancer($jobTitle, $pricePerHour, $sessionUserID);
				
				header('Location: ' . BASE_URL . $sessionUserType . "/profile/" . $sessionUser['user_id'] . "/?updated");
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
