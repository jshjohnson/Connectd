<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	if (isset($_GET['job_id'])) {
		$jobID = $_GET['job_id'];
	}
	
	if($jobID != '' && is_numeric($jobID)) {
		$jobs->deleteJob($jobID);
	}
?>