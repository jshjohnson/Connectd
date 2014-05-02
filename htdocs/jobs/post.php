<?php
	require("../config.php");  
	require(ROOT_PATH . "core/init.php");

	$users->loggedOutProtect();

	$jobCategories = $jobs->getJobCategories();
	$developerJobTitles = $freelancers->getFreelancerJobTitles("developer");
	$designerJobTitles = $freelancers->getFreelancerJobTitles("designer");

	$pageTitle = "Post a job";
	$pageType = "Page";
	$section = "Green";

	include_once(ROOT_PATH . "includes/header.inc.php");
	
	// Grab the form data
	$jobTitle       = trim($_POST['job_title']);
	$jobLocation    = trim($_POST['job_location']);
	$jobName        = trim($_POST['job_name']);
	$jobFull        = "I need a " . $jobTitle . " to work on " . $jobName;
	$startDate      = trim($_POST['start_date']);
	$deadline       = trim($_POST['deadline']);
	$budget         = trim($_POST['budget']);
	$category       = trim($_POST['category']);
	$description    = trim($_POST['description']);
	$submit         = trim($_POST['submit']);

	$status         = trim($_GET['status']);

	if (isset($_POST['submit'])){

		$forms->hijackPrevention();

       	$errors = $forms->validateJob($jobTitle, $jobLocation, $jobName, $startDate, $budget, $category, $description, $errors);

		if(empty($errors) === true){
			$jobs->postJob($sessionUserID, $jobFull, $jobLocation, $startDate, $deadline, $budget, $category, $description);
			header("Location:" . BASE_URL . "dashboard/");
			exit();
		}
	}
	include(ROOT_PATH . "views/job/job-post.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>