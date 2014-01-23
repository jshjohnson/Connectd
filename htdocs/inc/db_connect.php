<?php

	$db_hostname = 'localhost';
	$db_database = 'connectdDB'; // db name
	$db_username = 'jshjohnson'; // name
	$db_password = 'kerching27'; //password
	$db_status= 'not initialised'; 

	try {
		$db = new PDO("mysql:host=localhost;dbname=connectdDB;port=8888", "jshjohnson", "kerching27");	
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	} catch (Exception $e) {
		echo "Well would you look at that...the database is down";
		exit;
	}