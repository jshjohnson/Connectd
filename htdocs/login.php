<?php
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");
	
	if (isset($_GET['status'])) {
		$status = $_GET["status"];
	}

	if (isset ($_GET['email'], $_GET['email_code']) === true) {    
	    $email = trim($_GET['email']);
	    $email_code	= trim($_GET['email_code']);

		if ($users->emailExists($email) === false) {
			$errors[] = 'Sorry, we couldn\'t find that email address.';
		} else if ($users->activateUser($email, $email_code) === false) {
			$errors[] = 'Sorry, we couldn\'t activate your account.';
		}
        
	    if(!empty($errors) === false){
            header('Location: ' . BASE_URL . 'login/activated/');
            exit();
        }
    }

	if (isset($_SESSION['logged'])){
		header('Location: ' . BASE_URL . 'dashboard/');
	}else if (isset($_POST['submit'])) {
 
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);

		if(isset($_POST['remember'])) {
			$remember = trim($_POST['remember']);
			$year = time() + 31536000;
			$forms->rememberMe($remember, $email, $year);
		}
 
		$errors = $forms->validateLogin($email, $password);

		if(empty($errors) === true) {
	 
			$login = $users->doLogin($email, $password);

			if ($login === false) {
				$errors[] = 'Sorry, that username/password is invalid';
			}else{

	 			session_regenerate_id(true);// destroying the old session id and creating a new one
	 			$_SESSION['user_id'] =  $login; // The user's id is now set into the user's session  in the form of $_SESSION['id'] 
				$_SESSION['logged']="logged";
				
				$grantedAccess = $votes->userVotedFor($email);

				if($grantedAccess['granted_access'] >= 1) {
					if ($_COOKIE['firstVisit'] != "yes") { 
						setcookie("firstVisit", "yes", time()+315360000);  
						header('Location: ' . BASE_URL . 'dashboard/?status=firstvisit'); 
						exit();
					} else {
						header('Location: ' . BASE_URL . 'dashboard/');
						exit();
					}
				} else {
					header('Location:' . BASE_URL . 'welcome/');
					exit();
				}
			}
		}
	}

	$pageTitle = "Log In";
	$pageType = "Page";
	$section = "Blue";
	
	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/login/login-form.html");
	include(ROOT_PATH . "includes/footer.inc.php"); 
?>