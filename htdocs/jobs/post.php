<?php
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();

	$section   = "Jobs";
	$pageTitle = "Post a job";

	include_once(ROOT_PATH . "inc/header.php");
	
	// Grab the form data
	$jobName     = trim($_POST['job_name']);
	$startDate   = trim($_POST['start_date']);
	$deadline    = trim($_POST['deadline']);
	$budget      = trim($_POST['budget']);
	$category    = trim($_POST['category']);
	$description = trim($_POST['description']);
	$submit      = trim($_POST['submit']);

	$status      = trim($_GET['status']);

	if (isset($_POST['submit'])){

		// Form hijack prevention
		foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $message = "Hmmmm. Are you a robot? Try again.";
            }
        }
			
	    if($jobName == ""){
	        $errors[] = "Please enter a job title"; 
	    }else if($startDate == ""){
	        $errors[] = "Please enter a job deadline"; 
	    }else if($budget == ""){
	        $errors[] = "Please enter a minimum budget"; 
	    }else if($category == ""){
	        $errors[] = "Please enter a job category"; 
	    }else if($description == ""){
	        $errors[] = "Please enter a job description"; 
	    }

		if(empty($errors) === true){

			//clean the input now that we have a db connection
			$jobName        = $general->cleanString($db, $jobName);
			$startDate      = $general->cleanString($db, $startDate);
			$deadline       = $general->cleanString($db, $deadline);
			$budget         = $general->cleanString($db, $budget);
			$category       = $general->cleanString($db, $category);
			$description    = $general->cleanString($db, $description);

			$general->postJob($user_id, $jobName, $startDate, $deadline, $budget, $category, $description);
			header("Location:" . BASE_URL . "jobs/post.php?status=success");
			exit();
		}
	}

?>
	<header class="header header-green--alt zero-bottom cf">
		<div class="container">
			<h1 class="header__section header__section--title">
				Post a job<a href="" class="menu-trigger header__section--title__link "> : Menu</a>
			</h1>
			<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
			<h2 class="header__section header__section--logo">
				<a href="<?= BASE_URL; ?>">connectd</a>
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
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
				<?php if(empty($errors) === false) : ?>
					<p class="message message--error"> <?= implode('</p><p>', $errors); ?></p>
				<?php endif; ?>
				<?php if ($status == "success") : ?>
				<p class="message message--success">Successfully posted job. <a href="<?= BASE_URL . "dashboard/";?>">Go back to dashboard</a></p>
				<?php endif; ?>
				<form method="post" action="<?= BASE_URL; ?>jobs/post.php">
					<p class="message message--hint">Psst. Make your job titles as descriptive as possible - it will avoid confusion in the Connectd community.</p>
					<input type="text" name="job_name" placeholder="Job title" value="<?php if (isset($jobName)) { echo htmlspecialchars($jobName); } ?>" required="required">
					<div class="float-left field-1-2">
						<label for="">Start date:</label>
						<input type="date" name="start_date" placeholder="Start date" value="<?php if (isset($startDate)) { echo htmlspecialchars($startDate); } ?>" required="required">
					</div>
					<div class="float-right field-1-2">
						<label for="">Deadline: (if applicable)</label>
						<input type="date" name="deadline" placeholder="Deadline" value="<?php if (isset($deadline)) { echo htmlspecialchars($deadline); } ?>">
					</div>
					<div class="float-left field-1-2">
						<input type="text" name="budget" placeholder="Minimum budget" value="<?php if (isset($budget)) { echo htmlspecialchars($budget); } ?>" required="required">
					</div>
					<div class="select-container float-right field-1-2">
						<select name="category" required="required">
							<option value="">Select a category..</option>
							<option <?php if ($_POST['jobcategory'] == 'Web Design') { ?>selected="true" <?php }; ?>value="Web Design">Web Design</option>
							<option <?php if ($_POST['jobcategory'] == 'Graphic Design') { ?>selected="true" <?php }; ?>value="Graphic Design">Graphic Design</option>
							<option <?php if ($_POST['jobcategory'] == 'UX Design') { ?>selected="true" <?php }; ?>value="UX Design">UX Design</option>
							<option <?php if ($_POST['jobcategory'] == 'UI Design') { ?>selected="true" <?php }; ?>value="UI Design">UI Design</option>
							<option <?php if ($_POST['jobcategory'] == 'App Design') { ?>selected="true" <?php }; ?>value="App Design">App Design</option>
							<option <?php if ($_POST['jobcategory'] == 'Illustration') { ?>selected="true" <?php }; ?>value="Illustration">Illustration</option>
							<option <?php if ($_POST['jobcategory'] == 'Web Development') { ?>selected="true" <?php }; ?>value="Web Development">Web Development</option>
							<option <?php if ($_POST['jobcategory'] == 'App Development') { ?>selected="true" <?php }; ?>value="App Development">App Development</option>
						</select>
					</div>		
					<textarea name="description" cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!' required="required"><?php if (isset($jobdescription)) { echo htmlspecialchars($jobdescription); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Submit job'>						
					</div>
				</form> 
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>