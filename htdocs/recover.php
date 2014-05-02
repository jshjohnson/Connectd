<?php
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");

	$pageTitle = "Recover password";
	$pageType = "Page";
	$section = "Blue";

	if (isset($_GET['email'], $_GET['generated_string']) === true) {
            
		$email = trim($_GET['email']);
		$generatedString = trim($_GET['generated_string']);	

		if ($users->emailExists($email) === false) {
			$errors[] = 'Sorry, that email does not exist on our system.';
		} else if($users->recover($email, $generatedString) === false) {
			$errors[] = 'Sorry, we couldn\'t recover your password';
		}

		if (!empty($errors) === false) {  
			header('Location: '. BASE_URL . 'recover.php?success');
			exit();
		}else {
			header('Location: '. BASE_URL . 'settings/recover-password/');
			exit();
		}
	} 
	
	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/settings/recover.html");
	include(ROOT_PATH . "includes/footer.inc.php"); 
?>