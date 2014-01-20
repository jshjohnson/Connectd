<?php
	require_once("../inc/config.php"); 
	include_once(ROOT_PATH . "inc/checklog.php");

	$pageTitle = "Post a job";
	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/functions.php");

	// Grab the form data
	$jobtitle = trim($_POST['jobtitle']);
	$startdate = trim($_POST['startdate']);
	$deadline = trim($_POST['deadline']);
	$budget = trim($_POST['budget']);
	$jobcategory = trim($_POST['jobcategory']);
	$jobdescription = trim($_POST['jobdescription']);
	$submit = trim($_POST['submit']);

	// Create some variables to hold output data
	$message = '';
	$s_username = $_SESSION['email'];

	// Start to use PHP session
	session_start();

	if ($submit=='Submit job'){
			
	    if($jobtitle == ""){
	        $message = "Please enter a job title"; 
	    }else if($deadline == ""){
	        $message = "Please enter a job deadline"; 
	    }else if($budget == ""){
	        $message = "Please enter a minimum budget"; 
	    }else if($jobcategory == ""){
	        $message = "Please enter a job category"; 
	    }else if($jobdescription == ""){
	        $message = "Please enter a job description"; 
	    }else{
			// Process details here
			require_once(ROOT_PATH . "inc/db_connect.php"); //include file to do db connect
			if($db_server){

				//clean the input now that we have a db connection
				$jobtitle = clean_string($db_server, $jobtitle);
				$startdate = clean_string($db_server, $startdate);
				$deadline = clean_string($db_server, $deadline);
				$budget = clean_string($db_server, $budget);
				$jobcategory = clean_string($db_server, $jobcategory);
				$jobdescription = clean_string($db_server, $jobdescription);

				mysqli_select_db($db_server, $db_database);

				$query = "INSERT INTO connectdDB.jobs (jobtitle, startdate, deadline, budget, jobcategory, jobdescription, date) VALUES ('$jobtitle', '$startdate', '$deadline', '$budget', '$jobcategory', '$jobdescription', now())";
				mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
				header("Location:" . BASE_URL . "dashboard/");

			}else{
				$message = "Error: could not connect to the database.";
			}
			require_once(ROOT_PATH . "inc/db_close.php"); 
		}
	}

?>
	<header class="header header-green--alt zero-bottom cf">
		<div class="container">
			<h1 class="header__section header__section--title">
				Post a job<a href="" class="menu-trigger header__section--title__link "> : Menu</a>
			</h1>
			<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
			<h2 class="header__section header-logo">
				<a href="<?php echo BASE_URL; ?>">connectd</a>
			</h2>
		</div>
	</header>
	<section>
		<div class="section-heading color-green">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Let's get us the ball rolling...
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">
				<?php if (strlen($message)>70) : ?>
					<p class="error error--long"><?php echo $message; ?></p>
				<?php elseif (strlen($message)>1) : ?>
					<p class="error"><?php echo $message; ?></p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>post/index.php">
					<input type="text" name="jobtitle" placeholder="Job title">
					<div class="float-left field-1-2">
						<label for="">Start date:</label>
						<input type="date" name="startdate" placeholder="Start date" value="">
					</div>
					<div class="float-right field-1-2">
						<label for="">Deadline:</label>
						<input type="date" name="deadline" placeholder="Deadline" value="">
					</div>
					<div class="float-left field-1-2">
						<input type="text" name="budget" placeholder="Minimum budget" value="">
					</div>
					<div class="float-right field-1-2">
						<div class="select-container">
							<select name="jobcategory">
								<option value="">Select a category..</option>
								<option value="Web Design">Web Design</option>
								<option value="Graphic Design">Graphic Design</option>
								<option value="UX Design">UX Design</option>
								<option value="UI Design">UI Design</option>
								<option value="App Design">App Design</option>
								<option value="Illustration">Illustration</option>
								<option value="Web Development">Web Development</option>
								<option value="App Development">App Development</option>
							</select>
						</div>
					</div>			
					<textarea name="jobdescription" cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!'></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Submit job'>						
					</div>
				</form> 
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>