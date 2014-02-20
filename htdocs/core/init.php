<?php 
	#starting the users session
	session_start();
	require 'connect/database.php';

	require 'classes/users.php';
	require 'classes/developers.php';
	require 'classes/designers.php';
	require 'classes/employers.php';
	
	require 'classes/general.php';
	 
	$users 			= new Users($db);
	$developers		= new Developers($db);
	$designers		= new Designers($db);
	$employers 		= new Employers($db);

	$general 	= new General();
	 
	$errors 	= array();