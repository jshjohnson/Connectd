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

	$general 	    = new General($db);
	$users 			= new Users($db);
	$votes          = new Votes($db);

	$freelancers    = new Freelancers($db);
	$designers		= new Designers($db);
	$developers     = new Developers($db);
	$employers      = new Employers($db);
	$jobs	        = new Jobs($db);	
	$sessions		= new Sessions($db);
	$trials         = new Trials($db);
	
	$bcrypt         = new Bcrypt(12);
	$mail           = new PHPMailer(); // defaults to using php "mail()"
	 
	$errors 	    = array();

	
	if ($general->loggedIn() === true)  { // check if the user is logged in
		$user_id 	= $_SESSION['user_id']; // getting user's id from the session.
		$user 	= $users->userData($user_id); // getting all the data about the logged in user.
		$username = $user['firstname'] . " " . $user['lastname'];
		$userType = $user['user_type'];
	}
	