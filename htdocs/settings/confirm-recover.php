<?php
	require_once("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$pageTitle = "Recover password";
	$pageType = "Page";
	$section = "Blue";

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/settings/confirm-recover.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>