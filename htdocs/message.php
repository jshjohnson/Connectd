<?php 
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	$userFirstName = $_SESSION["userFirstName"];
	$userEmail = $_SESSION["userEmail"];
	$message = preg_replace('/\s*$^\s*/m', "\n", $_POST['message']);
	$sentByName = $sessionUsername;
	$sentByEmail = $sessionEmail;

	$emails->sendMessageEmail($userFirstName, $userEmail, $message, $sentByName, $sentByEmail);
	unset($userFirstName, $userEmail);
	header('Location: ' . $_SERVER['HTTP_REFERER'] . "?sent/");
	
?>