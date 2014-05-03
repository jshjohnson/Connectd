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

			// If less than 3 skills are set
			if(is_array($skills) && !empty($skills) && count($skills) < 3) {
				$errors[] = "You must specify at least 3 skills";
			}

			if(isset($_FILES['portfolio-piece']) && !empty($_FILES['portfolio-piece']['name'])) {
				// Number of uploaded files
				$num_files = count($_FILES['portfolio-piece']['name']);

				/** loop through the array of files ***/
				for($x =0; $x< $num_files;$x++){

					$image = $_FILES['portfolio-piece']['name'][$x];
					$tmp_name = $_FILES['portfolio-piece']['tmp_name'][$x];
					$allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'svg');
					$a = explode('.', $image);
					$file_ext = strtolower(end($a)); unset($a);
					$file_size = $_FILES['portfolio-piece']['size'][$x];
					$path = "assets/portfolio-pieces";

					if (in_array($file_ext, $allowed_ext) === false) {
						$errors[] = 'Image file type not allowed';	
					}	
					if ($file_size > 2097152) {
						$errors[] = 'File size must be under 2mb';
					}
   
					if(!is_uploaded_file($_FILES['portfolio-piece']['tmp_name'][$x])){
					    $errors[] = $image.' No file uploaded';
					}
				}
			}


			if(empty($errors) === true) {

				if (isset($_FILES['portfolio-piece']) && !empty($_FILES['portfolio-piece']['name'])) {
					$newpath = $forms->fileNewPath($path, $image);
					move_uploaded_file($tmp_name, $newpath);
				}

				$imageLocation = htmlentities(trim($newpath));

				$user->updateProfile($skills, $imageLocation, $testimonial, $testimonialSource); 
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
