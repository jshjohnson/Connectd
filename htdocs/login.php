<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

	$status = $_GET["status"];

	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {
 
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$submit = trim($_POST['submit']);
		$remember = trim($_POST['remember']);
		$year = time() + 31536000;

		$general->rememberMe($remember, $email, $year);
 
		if (empty($email) === true || empty($password) === true) {
			$errors[] = 'Sorry, but we need your username and password.';
		} else if ($users->emailExists($email) === false) {
			$errors[] = 'Sorry that username doesn\'t exist.';
		} else if ($users->emailConfirmed($email) === false) {
			$errors[] = 'Uh oh! Looks like your account hasn\'t been activated yet. <a href="">Resend confirmation email</a>' ;
		} else {
	 
			$login = $users->login($email, $password);

			if ($login === false) {
				$errors[] = 'Sorry, that username/password is invalid';
			}else{
				// username/password is correct and the login method of the $users object returns the user's id, which is stored in $login.
	 
	 			session_regenerate_id(true);// destroying the old session id and creating a new one
	 			$_SESSION['user_id'] =  $login; // The user's id is now set into the user's session  in the form of $_SESSION['id'] 
				$_SESSION['logged']="logged";
				
				if($votes->userVotedFor($email) === true) {
					if ($_COOKIE['firstVisit'] != "yes") { 
						setcookie("firstVisit", "yes", time()+315360000);  
						header("Location: dashboard?status=firstvisit"); 
						exit();
					} else {
						header('Location: dashboard/');
						exit();
					}
				} else {
					header('Location: welcome/');
					exit();
				}
			}
		}
	}

	$pageTitle = "Log In";
	$pageType = "Page";
	$section = "Blue";
	
	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/login-form.html");
	include_once(ROOT_PATH . "includes/footer.inc.php"); 
?>