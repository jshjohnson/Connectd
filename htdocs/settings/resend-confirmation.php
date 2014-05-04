<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$pageTitle = "Activate account";
	$pageType = "Page";
	$section = "Blue";

	if (isset($_POST['email']) === true) {
            
		$email = trim($_POST['email']);
		$emailCode = $users->fetchInfo('email_code', 'email', $email);
		$firstName = $users->fetchInfo('firstname', 'email', $email);


		if ($users->emailExists($email) === true) {
			$emails->sendConfirmationEmail($firstName, $email, $emailCode);
		} else {
			$errors[] = 'Sorry, that email does not exist on our system';
		}

		if (!empty($errors) === false) {  
			header('Location: '. BASE_URL . 'login/resent/');
			exit();
		}
	} 
	
	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/settings/email-input.html");
	include(ROOT_PATH . "includes/footer.inc.php"); 
?>