<?php
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();

	$jobCategories = $jobs->getJobCategories();
	$developerJobTitles = $freelancers->getFreelancerJobTitles("developer");
	$designerJobTitles = $freelancers->getFreelancerJobTitles("designer");


	$pageTitle     = "Post a job";
	$pageType      = "Page";
	$section       = "Green";

	include_once(ROOT_PATH . "includes/header.inc.php");
	
	// Grab the form data
	$jobTitle       = trim($_POST['job_title']);
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

		// Form hijack prevention
		foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $message = "Hmmmm. Are you a robot? Try again.";
            }
        }
			
	    
	    if($jobTitle == ""){
	        $errors[] = "Please enter a freelancer type"; 
	    }else if($jobName == ""){
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
			$jobs->postJob($user_id, $jobFull, $startDate, $deadline, $budget, $category, $description);
			header("Location:" . BASE_URL . "jobs/post.php?status=success");
			exit();
		}
	}

?>
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
	<section class="footer--push color-grey">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
				<?php if(empty($errors) === false) : ?>
					<p class="message message--error shake"> <?= implode('</p><p>', $errors); ?></p>
				<?php endif; ?>
				<?php if ($status == "success") : ?>
				<p class="message message--success fadeIn">Successfully posted job. <a href="<?= BASE_URL . "dashboard/";?>">Go back to dashboard</a></p>
				<?php endif; ?>
				<form method="post" action="<?= BASE_URL; ?>jobs/post.php">
				<p class="message message--hint">Psst. Make your job titles as descriptive as possible - it will avoid confusion in the Connectd community.</p>
					<fieldset class="cf text-center">
						<label for="">I need a</label>
						<div class="select-container select-container--inline">
							<select name="job_title">
								<?php foreach ($designerJobTitles as $jobTitle) : ?>
									<option <?php if ($_POST['job_title'] == $jobTitle) { ?>selected="true" <?php }; ?>value="<?= $jobTitle; ?>"><?= $jobTitle; ?></option>
								<?php endforeach; ?>
								<?php foreach ($developerJobTitles as $jobTitle) : ?>
									<option <?php if ($_POST['job_title'] == $jobTitle) { ?>selected="true" <?php }; ?>value="<?= $jobTitle; ?>"><?= $jobTitle; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<label for="">to work on</label>
						<input type="text" name="job_name" placeholder="creating 10 HTML templates" value="<?php if (isset($jobName)) { echo htmlspecialchars($jobName); } ?>">
					</fieldset>
					<div class="float-left field-1-2">
						<label for="">Start date:</label>
						<input type="date" name="start_date" placeholder="Start date" value="<?php if (isset($startDate)) { echo htmlspecialchars($startDate); } ?>">
					</div>
					<div class="float-right field-1-2">
						<label for="">Deadline: (if applicable)</label>
						<input type="date" name="deadline" placeholder="Deadline" value="<?php if (isset($deadline)) { echo htmlspecialchars($deadline); } ?>">
					</div>
					<div class="currency-container field-1-2 float-left">
						<span class="currency-prepend">£</span>
						<input type="number" name="budget" placeholder="Minimum budget" min="1" class="input--currency" value="<?php if (isset($budget)) { echo htmlspecialchars($budget); } ?>">
					</div>
					<div class="select-container float-right field-1-2">
						<select name="category" required="required">
							<option value="">Select a category..</option>
							<?php foreach ($jobCategories as $jobCategory) : ?>
								<option <?php if ($_POST['category'] == $jobCategory['job_category']) { ?>selected="true" <?php }; ?>value="<?= $jobCategory['job_category']; ?>"><?= $jobCategory['job_category']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>		
					<textarea name="description" cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!' required="required"><?php if (isset($description)) { echo htmlspecialchars($description); } ?></textarea>
					<div class="btn-container">
		            	<input class="btn--green" name="submit" type="submit" value='Submit job'>						
					</div>
				</form> 
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>