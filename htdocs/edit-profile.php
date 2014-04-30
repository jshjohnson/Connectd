<?php
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();

	$pageTitle = "Edit Profile";
	$pageType = "Page";
	$section = "Blue";

	if(empty($_POST) === false) {

		$firstName = trim($_POST['firstname']);
		$lastName = trim($_POST['lastname']);
		$email = trim($_POST['email']);
		$portfolio = trim($_POST['portfolio']);
		$bio = trim($_POST['bio']);
	
		if (isset($firstName) && !empty($firstName)){ 
			if (ctype_alpha($firstName) === false) {
				$errors[] = 'Please enter your first name with only letters';
			}	
		} else {
			$errors[] = 'Please enter your first name';
		}

		if (isset($lastName) && !empty ($lastName)){
			if (ctype_alpha($lastName) === false) {
				$errors[] = 'Please enter your last name with only letters';
			}	
		} else {
			$errors[] = 'Please enter your last name';
		}

		if(empty($email)){
			$errors[] = "Please enter your email"; 
		}else if($email != $sessionEmail) {
			if (!$mail->ValidateAddress($email)){
				$errors[] = "You must specify a valid email address.";
			}else if ($users->emailExists($email) === true) {
			    $errors[] = "Email already taken. Please try again.";
			}
		}

		if (empty($bio)){
			$errors[] = 'Please enter a bio';
		}else if(strlen($bio)<25) {
			$errors[] = "You're not going to sell yourself without a decent bio!";
		}
		
		if(empty($portfolio)){
			$errors[] = "Please specify a valid portfolio"; 
		}

		if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {	
			$name 			= $_FILES['avatar']['name'];
			$tmp_name 		= $_FILES['avatar']['tmp_name'];
			$allowed_ext 	= array('jpg', 'jpeg', 'png', 'gif', 'svg');
			$a 				= explode('.', $name);
			$file_ext 		= strtolower(end($a)); unset($a);
			$file_size 		= $_FILES['avatar']['size'];
			$path 			= "assets/avatars";
			
			if (in_array($file_ext, $allowed_ext) === false) {
				$errors[] = 'Image file type not allowed';	
			}	
			if ($file_size > 2097152) {
				$errors[] = 'File size must be under 2mb';
			}
			
		} else {
			$newpath = $sessionAvatar;
		}

		if(empty($errors) === true) {
			
			if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
				$newpath = $forms->fileNewPath($path, $name);
				move_uploaded_file($tmp_name, $newpath);
			}
					
			$firstName 	= htmlentities(trim($_POST['firstname']));
			$lastName = htmlentities(trim($_POST['lastname']));	
			$bio = htmlentities(trim($_POST['bio']));
			$imageLocation = htmlentities(trim($newpath));
			
			$users->updateUser($firstName, $lastName, $portfolio, $email, $bio, $imageLocation, $sessionUserID);
			header('Location: ' . BASE_URL . 'edit-profile/?success');
			exit();
		
		}	
    }

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/settings/edit-profile.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>