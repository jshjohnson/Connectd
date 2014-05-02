<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$pageTitle = "Recover password";
	$pageType = "Page";
	$section = "Blue";

	if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
		$email = $_POST['email'];
		if ($users->emailExists($email) === true){
			$users->confirmRecover($email);
			header('Location:' . BASE_URL . 'settings/recover-password/?success');
			exit();
		} else {
			$errors[] = 'Sorry, that email doesn\'t exist.';
		}
	}
	
	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/settings/confirm-recover.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>