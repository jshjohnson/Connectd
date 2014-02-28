<?php 
	session_start();
	require 'connect/database.php';

	require 'inc/phpmailer/class.phpmailer.php';

	require 'classes/users.php';
	require 'classes/developers.php';
	require 'classes/designers.php';
	require 'classes/employers.php';
	require 'classes/bcrypt.php';
	require 'classes/general.php';

	$mail           = new PHPMailer(); // defaults to using php "mail()"
	 
	$users 			= new Users($db);
	$developers		= new Developers($db);
	$designers		= new Designers($db);
	$employers 		= new Employers($db);

	$general 	    = new General($db);
	$bcrypt        = new Bcrypt(12);

	if ($general->loggedIn () === true)  { // check if the user is logged in
		$user_id 	= $_SESSION['id']; // getting user's id from the session.
		$user 	= $users->userData($user_id); // getting all the data about the logged in user.
		$username = $user['firstname'] . " " . $user['lastname'];
		$user_type = $user['user_type'];
	}
	 
	$errors 	    = array();
	