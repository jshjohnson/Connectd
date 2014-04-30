<?php
	require("../config.php");
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();
	$users->loggedInProtect();

	$towns = $users->getLocations();
	$employerTypes = $employers->getEmployerTypes();
	$experiences = $users->getExperiences();

	$pageTitle = "Sign Up";
	$pageType = "Page";
	$section = "Green";

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

	$userIP = $ipInfo->getIPAddress();
	$userLocation = json_decode($ipInfo->getCity($userIP), true);
	$userCity = $userLocation['cityName'];

	if (isset($_GET['status'])) {
		$status = $_GET["status"];
	}
	
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {

		$forms->hijackPrevention();

		$errors = $forms->validateEmployer($firstName, $lastName, $email, $password, $repeatPassword, $employerName, $employerType, $experience, $bio);

		if(empty($errors) === true) {
			$userType = 'employer';
			$data = array(
				"firstName" => $firstName, 
				"lastName" => $lastName, 
				"email" => $email, 
				"password" => $password, 
				"location" => $location, 
				"portfolio" => $portfolio, 
				"employerName" => $employerName, 
				"employerType" => $employerType, 
				"experience" => $experience, 
				"bio" => $bio, 
				"userType" => $userType
			);
			$employers->registerEmployer($data);
			header("Location:" . BASE_URL . "login/success/");
			exit();
		}

	}

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/employer/employer-signup-form.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>