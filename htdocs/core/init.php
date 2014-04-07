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
		$filename = ROOT_PATH . "core/classes/" . strtolower($class) . ".php";
	    if (is_readable($filename)) {
	        require($filename);
	    }
	}
	spl_autoload_register('class_loader');	

	require 'inc/phpmailer/PHPMailerAutoload.php';
	require 'inc/ipInfo.php';

	$general 	    = new General();
	$users 			= new Users($db);
	$votes          = new Votes($db);
	$freelancers    = new Freelancers($db);
	$employers      = new Employers($db);
	$jobs	        = new Jobs($db);	
	$sessions		= new Sessions($db);
	$trials         = new Trials($db);

	$bcrypt         = new Bcrypt(12);
	$mail           = new PHPMailer();
	$ipInfo         = new ipInfo(ae08ebea8c44bdebba68f45182b6f63126dbeed2932aa6acdcf71b408f61e6b1, 'json');
	 
	$errors 	    = array();
	
	// error_reporting(0);
	
	if ($users->loggedIn() === true)  { // check if the user is logged in
		$user_id = $_SESSION['user_id']; // getting user's id from the session.
		$user = $users->userData($user_id); // getting all the data about the logged in user.
		$username = $user['firstname'] . " " . $user['lastname'];
		$sessionUserType = $user['user_type'];
		$avatar = $user['image_location'];
	}
	