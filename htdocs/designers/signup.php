<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedInProtect();

	$towns = $users->getLocations();
	$experiences = $users->getExperiences();

	$userType = "designer";
	$jobTitles = $freelancers->getFreelancerJobTitles($userType);

	// Grab the form data
	$firstName = trim($_POST['firstname']);
	$lastName = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatPassword = trim($_POST['repeatpassword']);
	$jobTitle = trim($_POST['jobtitle']);
	$experience = trim($_POST['experience']);
	$pricePerHour = trim($_POST['priceperhour']);
	$bio = preg_replace('/\s*$^\s*/m', "\n", $_POST['bio']);
	$portfolio = trim($_POST['portfolio']);
	$location = trim($_POST['location']);
	$submit = trim($_POST['submit']);

	$status = $_GET["status"];

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {

		$general->hijackPrevention();
	 		        
		$r1='/[A-Z]/';  // Test for an uppercase character
		$r2='/[a-z]/';  // Test for a lowercase character
		$r3='/[0-9]/';  // Test for a number

		if($firstName == ""){
		    $errors[] ="Please enter your first name"; 
		}else if($lastName == ""){
		    $errors[] ="Please enter your last name"; 
		}else if($email == ""){
		    $errors[] ="Please enter your email"; 
		}else if (!$mail->ValidateAddress($email)){
				$errors[] = "You must specify a valid email address.";
		}else if ($users->emailExists($email) === true) {
		    $errors[] = "Email already taken. Please try again.";
		}else if($password == ""){
		    $errors[] ="Please enter a password"; 
		}else if ($password!=$repeatPassword){ 
			$errors[] = "Both password fields must match";
		} else if(preg_match_all($r1,$password, $o)<1) {
			$errors[] = "Your password needs to contain at least one uppercase character";
		} else if(preg_match_all($r2,$password, $o)<1) {
			$errors[] = "Your password needs to contain at least one lowercase character";
		} else if(preg_match_all($r3,$password, $o)<1) {
			$errors[] = "Your password needs to contain at least one number";
		} else if (strlen($password)>25||strlen($password)<6) {
			$errors[] = "Password must be 6-25 characters long";
		} else if($portfolio == ""){
		    $errors[] ="You must have an active portfolio to join Connectd"; 
		} else if($jobTitle == ""){
		    $errors[] ="Please select your current job title"; 
		}else if($experience == ""){
		    $errors[] ="Please enter your experience"; 
		}else if($bio == ""){
		    $errors[] ="Please write about yourself"; 
		}else if(strlen($bio)<25) {
			$errors[] = "You're not going to sell yourself without a decent bio!";
		}

		if(empty($errors) === true){
			$freelancers->registerFreelancer($firstName, $lastName, $email, $password, $location, $portfolio, $jobTitle, $pricePerHour, $experience, $bio, $userType);
			header("Location:" . BASE_URL . "designers/signup.php?status=success");
			exit();
		}
	}

	$pageTitle = "Sign Up";
	$pageType = "Page";
	$section = "Blue";
	
	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/freelancer-signup-form.html");
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>