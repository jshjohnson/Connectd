<?php
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$pageTitle = "Recover password";
	$pageType = "Page";
	$section = "Blue";
	$url = basename($_SERVER['REQUEST_URI']);
	
	if (empty($_POST) === false) {

		if(isset($_POST['email']) === true && empty($_POST['email']) === false) {

			$email = trim($_POST['email']);

			if($url == "recover-password") {
				if ($users->emailExists($email) === true){
					$users->confirmRecover($email);
				} else {
					$errors[] = 'Sorry, that email doesn\'t exist.';
				}

				if (!empty($errors) === false) {
					header('Location:' . BASE_URL . 'settings/recover-password/?success');
					exit();
				}

			}else if($url == "resend") {
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
		}
	}
	
	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/settings/email-input.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>