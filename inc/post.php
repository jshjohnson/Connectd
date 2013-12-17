<?php

	$jobtitle = trim($_POST['jobtitle']);
	$startdate = trim($_POST['startdate']);
	$deadline = trim($_POST['deadline']);
	$budget = trim($_POST['budget']);
	$jobcategory = trim($_POST['jobcategory']);
	$jobdescription = trim($_POST['jobdescription']);
	$submit = trim($_POST['submit']);

	if ($submit=='Submit job'){
				
	    if($jobtitle == ""){
	        $message="Please enter a job title"; 
	    }else if($deadline == ""){
	        $message="Please enter a job deadline"; 
	    }else if($budget == ""){
	        $message="Please enter a minimum budget"; 
	    }else if($jobcategory == ""){
	        $message="Please enter a job category"; 
	    }else if($jobdescription == ""){
	        $message="Please enter a job description"; 
	    }else{
			session_start(); 
			require_once(ROOT_PATH . "inc/db_connect.php");

			if($db_server){

				//clean the input now that we have a db connection
				$jobtitle = clean_string($db_server, $jobtitle);
				$startdate = clean_string($db_server, $startdate);
				$deadline = clean_string($db_server, $deadline);
				$budget = clean_string($db_server, $budget);
				$jobcategory = clean_string($db_server, $jobcategory);
				$jobdescription = clean_string($db_server, $jobdescription);


				mysqli_select_db($db_server, $db_database);

				$query = "INSERT INTO connectdDB.jobs (jobtitle, startdate, deadline, budget, jobcategory, jobdescription) VALUES ('$jobtitle', '$startdate', '$deadline', '$budget', '$jobcategory', '$jobdescription')";
				mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
				header("Location:" . BASE_URL . "dashboard.php");
			}else{
				$message = "Error: could not connect to the database.";
			}
		   require_once(ROOT_PATH . "inc/db_close.php");
		}
	}