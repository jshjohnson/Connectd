<?php 
	session_start();
	require 'connect/database.php';

	require 'classes/users.php';
	require 'classes/bcrypt.php';
	require 'classes/general.php';
	require 'classes/votes.php';
	require 'classes/employers.php';
	require 'classes/developers.php';
	require 'classes/designers.php';
	require 'classes/freelancers.php';
	require 'classes/jobs.php';
	require 'classes/sessions.php';
	require 'classes/trials.php';

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
	