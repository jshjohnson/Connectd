<?php 	
	require("../config.php");
	require(ROOT_PATH . "core/init.php");
	
	$debug->showErrors();
	$users->loggedOutProtect();

	$pageTitle = "Search";
	$pageType = "Page";
	$section = "Blue";

	include(ROOT_PATH . "includes/header.inc.php");
?>


<?php include(ROOT_PATH . "includes/footer.inc.php"); ?>