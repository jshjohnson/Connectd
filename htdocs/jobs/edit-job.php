<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	
	$users->loggedOutProtect();

	$pageTitle = "Edit Job Post";

	try {

		if (isset($_GET['job_id'])) {
			$jobID = $_GET['job_id'];
			$job = $jobs->getJobsSingle($jobID);
			$pageID = $job['user_id'];
			$user = $employers->getEmployersSingle($pageID);
			$employerName = $user['employer_name'];
			$developerJobTitles = $freelancers->getFreelancerJobTitles("developer");
			$designerJobTitles = $freelancers->getFreelancerJobTitles("designer");
			$jobCategories = $jobs->getJobCategories();
		}

		if(empty($_POST) === false) {

			$jobTitle = trim($_POST['job_title']);
			$jobLocation = trim($_POST['job_location']);
			$jobName = stripslashes(trim($_POST['job_name']));
			$jobFull = $employerName . " need a " . $jobTitle . " to work on " . $jobName;
			$startDate = trim($_POST['start_date']);
			$deadline = trim($_POST['deadline']);
			$budget = trim($_POST['budget']);
			$category = trim($_POST['category']);
			$description = trim($_POST['description']);

			if(empty($errors) === true) {
			
			}
		}

		include(ROOT_PATH . "includes/header.inc.php");
		include(ROOT_PATH . "views/job/job-edit.html");
		include(ROOT_PATH . "includes/footer.inc.php");

	}catch(Exception $e) {
		$users = new Users($db);
		$debug = new Errors();
		$debug->errorView($users, $e);	
	}
?>
