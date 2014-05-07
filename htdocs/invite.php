<?php 
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);

	if (isset($_GET['email'])) {
		$email = $_GET['email'];
	}

	$emails->sendInviteEmail($email);

	echo "Invite sent";
	
?>