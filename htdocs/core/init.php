<?php 
	session_start();
	require 'connect/database.php';

	/**
	 * Require all classes in `classes` folder
	 *
	 * @param  string $class
	 * @return void
	 */ 
	function class_loader($class) {
		$filename = ROOT_PATH . "core/classes/" . strtolower($class) . ".class.php";
	    if (is_readable($filename)) {
	        require($filename);
	    }
	}
	spl_autoload_register('class_loader');	

	require 'inc/phpmailer/PHPMailerAutoload.php';
	require 'inc/ipInfo.php';

	$users = new Users($db);
	$freelancers = new Freelancers($db);
	$employers = new Employers($db);
	$jobs = new Jobs($db);	
	$votes = new Votes($db);
	$stars = new Stars($db);
	$trials = new Trials($db);
	$search = new Search($db);
	$debug = new Errors();
	$emails = new Emails();
	$forms = new Forms($db);
	$urls = new URLs();
	$bcrypt = new Bcrypt(12);
	$mail = new PHPMailer();
	$ipInfo = new ipInfo('ae08ebea8c44bdebba68f45182b6f63126dbeed2932aa6acdcf71b408f61e6b1', 'json');
	 
	$errors = array();
	
	// error_reporting(0);
	
	if ($users->loggedIn() === true)  { // check if the user is logged in
		$sessionUserID = $_SESSION['user_id']; // getting user's id from the session.
		$sessionUser = $users->userData($sessionUserID); // getting all the data about the logged in user.
		$sessionUsername = $sessionUser['firstname'] . " " . $sessionUser['lastname'];
		$sessionEmail = $sessionUser['email'];
		$sessionUserType = $sessionUser['user_type'];
		$sessionAvatar = $sessionUser['image_location'];
		$sessionAvatarPath = 'assets/avatars/';
		$sessionAvatarFile = str_replace($sessionAvatarPath, '', $sessionAvatar);

		if($sessionUserType == "employer") {
			$sessionEmployerData = $employers->getEmployersSingle($sessionUserID);
			$sessionEmployerName = ucwords($sessionEmployerData['employer_name']);	
		}
	}
	