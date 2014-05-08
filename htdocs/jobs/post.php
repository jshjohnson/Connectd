<?php
	require("../config.php");  
	require(ROOT_PATH . "core/init.php");

	$users->loggedOutProtect();
	$debug->showErrors();

	$jobCategories = $jobs->getJobCategories();
	$developerJobTitles = $freelancers->getFreelancerJobTitles("developer");
	$designerJobTitles = $freelancers->getFreelancerJobTitles("designer");

	$pageTitle = "Post a job";
	$pageType = "Page";
	$section = "Green";

	if(isset($_GET['status'])) {
		$status = trim($_GET['status']);
	} 

	if (isset($_POST['submit'])){

		$employerName = $users->fetchInfo("employer_name", "employer_id", $sessionUserID, "employers");

		// Grab the form data
		$freelancerNeeded = trim($_POST['job_title']);
		$jobLocation = trim($_POST['job_location']);
		$jobName = stripslashes(trim($_POST['job_name']));
		$jobFull = $employerName . " need a " . $freelancerNeeded . " to work on " . $jobName;
		$startDate = trim($_POST['start_date']);
		$deadline = trim($_POST['deadline']);
		$budget = trim($_POST['budget']);
		$category = trim($_POST['category']);
		$description = trim($_POST['description']);

		$forms->hijackPrevention();

       	$errors = $forms->validateJob($freelancerNeeded, $jobLocation, $jobName, $startDate, $budget, $category, $description, $errors);

		if(empty($errors) === true){
			$jobs->postJob($sessionUserID, $jobFull, $freelancerNeeded, $jobLocation, $startDate, $deadline, $budget, $category, $description);
			header("Location:" . BASE_URL . "dashboard/");
			exit();
		}
	}

	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/job/job-post.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>