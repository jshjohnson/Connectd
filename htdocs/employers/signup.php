<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedInProtect();

	$towns              = $users->getLocations();
	$employerTypes      = $employers->getEmployerTypes();
	$experiences        = $users->getExperiences();

	$pageTitle          = "Sign Up";
	$pageType           = "Page";
	$section            = "Green";

	// Grab the form data
	$firstName = trim($_POST['firstname']);
	$lastName = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatPassword = trim($_POST['repeatpassword']);
	$employerName = trim($_POST['employer_name']);
	$employerType = trim($_POST['employer_type']);
	$location = trim($_POST['location']);
	$experience = trim($_POST['experience']);
	$portfolio = trim($_POST['portfolio']);
	$bio = trim($_POST['bio']);
	$submit = trim($_POST['submit']);

	if (isset($_GET['status'])) {
		$status = $_GET["status"];
	}
	
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {

		$general->hijackPrevention();

		// Form hijack prevention
		foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $errors[] = "Hmmmm. Are you a robot? Try again.";
            }
        }

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
   			 $errors[]  = "You must specify a valid email address.";
		}else if ($users->emailExists($email) === true) {
		    $errors[] = "Email already taken. Please try again.";
		}else if($password == ""){
	        $errors[] ="Please enter a password"; 
	    }else if ($password!=$repeatPassword){ 
			$errors[]  = "Both password fields must match";
		}else if(preg_match_all($r1,$password, $o)<1) {
			$errors[]  = "Your password needs to contain at least one uppercase character";
		}else if(preg_match_all($r2,$password, $o)<1) {
			$errors[]  = "Your password needs to contain at least one lowercase character";
		}else if(preg_match_all($r3,$password, $o)<1) {
			$errors[]  = "Your password needs to contain at least one number";
		}else if (strlen($password)>25||strlen($password)<6) {
			$errors[]  = "Password must be 6-25 characters long";
		}else if($employerName == ""){
	        $errors[]  = "Please enter your business name"; 
	    }else if($employerType == ""){
	        $errors[]  = "Please enter your business type"; 
	    }else if($experience == ""){
		    $errors[] ="Please enter your experience";
		}else if($bio == ""){
	        $errors[]  = "Please write about your business"; 
	    }else if(strlen($bio)<25) {
			$errors[]  = "Freelancers require a bit more information about your business!";
		}

		if(empty($errors) === true) {
			$userType = 'employer';
			$employers->registerEmployer($firstName, $lastName, $email, $password, $location, $portfolio, $employerName, $employerType, $experience, $bio, $userType);
			header("Location:" . BASE_URL . "employers/signup.php?status=success");
			exit();
		}

	}

	$pageTitle = "Sign Up";
	$pageType = "Page";
	$section = "Green";

	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/employer-signup-form.html");
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>