<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	$pageTitle = "Account Settings";
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
			$tmpName 		= $_FILES['avatar']['tmp_name'];
			$allowedExt 	= array('jpg', 'jpeg', 'png', 'gif');
			$a 				= explode('.', $name);
			$fileExt 		= strtolower(end($a)); unset($a);
			$fileSize 		= $_FILES['avatar']['size'];
			$path 			= "assets/avatars";
			
			if (in_array($fileExt, $allowedExt) === false) {
				$errors[] = 'Image file type not allowed';	
			}	
			if ($fileSize > 2097152) {
				$errors[] = 'File size must be under 2mb';
			}
			
		} else {
			$newPath = $sessionAvatar;
		}

		if(empty($errors) === true) {
			
			if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
				$uniqueName = $sessionUserID.time();

				$newName = $uniqueName . '.' . $fileExt;
				$newPath = $forms->fileNewPath($path, $newName);

				move_uploaded_file($tmpName, ROOT_PATH . $newPath);

				$resize = new Resize(ROOT_PATH . $newPath);
				$resize->resizeImage(600, 400, 'auto');
				$resize->saveImage(ROOT_PATH . $newPath, 100);

				$thumbnailName = 'thumbnail-' . $uniqueName . '.' . $fileExt;
				$thumbnailPath = $forms->fileNewPath($path, $thumbnailName);

				$resize = new Resize(ROOT_PATH . $newPath);
				$resize->resizeImage(150, 150, 'crop');
				$resize->saveImage(ROOT_PATH . $thumbnailPath, 100);
			}
					
			$firstName 	= htmlentities(trim($_POST['firstname']));
			$lastName = htmlentities(trim($_POST['lastname']));	
			$bio = htmlentities(trim($_POST['bio']));
			$imageLocation = htmlentities(trim($newPath));
			
			$users->updateUser($firstName, $lastName, $portfolio, $email, $bio, $imageLocation, $sessionUserID);
			header('Location: ' . BASE_URL . 'settings/account-settings/?success');
			exit();
		}	
    }

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/settings/account-settings.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>