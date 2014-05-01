<?php 
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	// $votes->userVotedForProtect();

	$userFirstName = $_SESSION["userFirstName"];
	$userEmail = $_SESSION["userEmail"];
	$message = preg_replace('/\s*$^\s*/m', "\n", $_POST['message']);
	$sentBy = $username;

	$emails->sendMessageEmail($userFirstName, $userEmail, $message, $sentBy);
	unset($userFirstName, $userEmail);
	header('Location: ' . $_SERVER['HTTP_REFERER'] . "sent/");
	
?>