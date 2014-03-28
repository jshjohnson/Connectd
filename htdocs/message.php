<?php 
	require_once("config/config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	// $votes->userVotedForProtect();

	$firstName = trim($_POST['firstname']);
	$email = trim($_POST['email']);
	$message = trim($_POST['message']);
	$sentBy = $username; // Session username

	// if (isset($_GET['email'])) {
	// 	$email= $_GET['email'];
	// }

	// if (isset($_GET['firstname'])) {
	// 	$firstname= $_GET['firstname'];
	// }
	
	$general->sendMessageEmail($firstName, $email, $message, $sentBy);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
?>