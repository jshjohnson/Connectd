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

	$general 	    = new General();
	$bcrypt        = new Bcrypt();
	 
	$errors 	    = array();
	