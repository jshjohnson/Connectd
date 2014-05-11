<?php 
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	$userFirstName = $_SESSION["userFirstName"];
	$userEmail = $_SESSION["userEmail"];

	$userID = $users->fetchInfo("user_id", "email", $userEmail);

	$getUserType = $users->userType($userID);
	$userUserType = $getUserType['user_type'];

	$jobID = $_SESSION["job_id"];

	$message = preg_replace('/\s*$^\s*/m', "\n", $_POST['message']);
	$sessionProfileURL = $sessionUserType . "/profile/" . $sessionUserID . "/";;

	if(!empty($jobID) && strpos($_SERVER['HTTP_REFERER'],'/job/')) {
		$jobs->insertJobApplication($sessionUserID, $jobID);
		$emails->sendJobApplicationEmail($userFirstName, $userEmail, $message, $sessionUsername, $sessionEmail, $sessionProfileURL);
	} else {
		$emails->sendMessageEmail($userFirstName, $userEmail, $message, $sessionUsername, $sessionEmail, $sessionProfileURL);
	}
	
	unset($userFirstName, $userEmail);
	header('Location: ' . $_SERVER['HTTP_REFERER'] . "?sent/");
	
?>