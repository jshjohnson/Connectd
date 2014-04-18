<?php 	
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");
	
	$debug->showErrors();
	$users->loggedOutProtect();

	$pageTitle = "Search";
	$pageType = "Page";
	$section = "Blue";

	include_once(ROOT_PATH . "includes/header.inc.php");
?>


<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>