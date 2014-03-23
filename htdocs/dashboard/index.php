<?php
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();
	// $votes->userVotedForProtect();

	$designers    = $designers->get_designers_all();
	$developers   = $developers->get_developers_all();
	$employers    = $employers->get_employers_all();
	$jobs         = $jobs->get_jobs_all();

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}

	$pageTitle    = "Dashboard";
	$section      = "Dashboard";

	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/dashboard.html");
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>
