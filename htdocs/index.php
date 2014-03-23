<?php 	
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");
	
	$general->errors();
	$general->loggedInProtect();

	$pageTitle         = "Connectd";
	$pageType          = "Home";
	$section           = "Home";

	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/index.html");
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>
