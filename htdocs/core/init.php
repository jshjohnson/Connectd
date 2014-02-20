<?php 
	#starting the users session
	session_start();
	require 'connect/database.php';
	require 'classes/users.php';
	require 'classes/general.php';
	 
	$users 		= new Users($db);
	$general 	= new General();
	 
	$errors 	= array();