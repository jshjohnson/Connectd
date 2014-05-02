<?php 
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php"); 

	$users->loggedOutProtect();
	
	try {

		if (isset($_GET['type'])) {
			$type = $_GET['type'];
		}else {
			throw new Exception('A user type was not set.');
			$type = NULL;
		}

		$status = $_GET["status"];

		switch ($type) {
			case "designer":
				$section = "Designer";
				$users->loggedOutProtect();
				$pageTitle = "Designer list";
				break;
			case "developer":
				$section = "Developer";
				$users->loggedOutProtect();
				$pageTitle = "Developer list";
				break;
			case "employer":
				$section = "Employer";
				$users->loggedOutProtect();
				$pageTitle = "Employer list";
				break;
			case "jobs":
				$section = "Jobs";
				$users->loggedOutProtect();
				$pageTitle = "Job list";
				break;
			default:
				$template = "index/index.html";
				$pageTitle = "Connectd";
				$pageType = "Home";
				$section = "Home";
				$users->loggedInProtect();
				break;
		}

		if($type == "developer" || $type == "designer") {
			$freelancers = $freelancers->getFreelancersAll($userType);	
			$freelancer_id = $_GET["id"];	
			$template = "list-user.html";
		} else if ($type == "employer") {
			$employers = $employers->getEmployersAll($userType);
			$employer_id = $_GET["id"];
			$template = "list-user.html";
		} else if ($type == "jobs") {
			$allJobs = $jobs->getJobsAll();
			$template = "list-job.html";
		}

		include(ROOT_PATH . "includes/header.inc.php");
		include(ROOT_PATH . "views/page/" . $template);
		include(ROOT_PATH . "includes/footer.inc.php");

	}catch(Exception $e) {
		$users = new Users($db);
		$debug = new Errors();
		$debug->errorView($users, $e);	
	}
?>		