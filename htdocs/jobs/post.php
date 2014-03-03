<?php
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();

	$section = "Jobs";
	$pageTitle = "Post a job";

	include_once(ROOT_PATH . "inc/header.php");
	
	// Grab the form data
	$jobtitle = trim($_POST['jobtitle']);
	$startdate = trim($_POST['startdate']);
	$deadline = trim($_POST['deadline']);
	$budget = trim($_POST['budget']);
	$jobcategory = trim($_POST['jobcategory']);
	$jobdescription = trim($_POST['jobdescription']);
	$submit = trim($_POST['submit']);

	if ($submit=='Submit job'){

		// Form hijack prevention
		foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $message = "Hmmmm. Are you a robot? Try again.";
            }
        }
			
	    if($jobtitle == ""){
	        $message = "Please enter a job title"; 
	    }else if($startdate == ""){
	        $message = "Please enter a job deadline"; 
	    }else if($budget == ""){
	        $message = "Please enter a minimum budget"; 
	    }else if($jobcategory == ""){
	        $message = "Please enter a job category"; 
	    }else if($jobdescription == ""){
	        $message = "Please enter a job description"; 
	    }else{

			//clean the input now that we have a db connection
			$jobtitle       = $general->cleanString($db, $jobtitle);
			$startdate      = $general->cleanString($db, $startdate);
			$deadline       = $general->cleanString($db, $deadline);
			$budget         = $general->cleanString($db, $budget);
			$jobcategory    = $general->cleanString($db, $jobcategory);
			$jobdescription = $general->cleanString($db, $jobdescription);
			$time 		    = time();

			try {
				$result = $db->prepare("INSERT INTO connectdDB.jobs(user_id, jobtitle, startdate, deadline, budget, jobcategory, jobdescription, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
				$result->bindValue(1, $user_id);
				$result->bindValue(2, $jobtitle);
				$result->bindValue(3, $startdate);
				$result->bindValue(4, $deadline);
				$result->bindValue(5, $budget);
				$result->bindValue(6, $jobcategory);
				$result->bindValue(7, $jobdescription);
				$result->bindValue(8, $time);

				$result->execute();
			
			} catch (Exception $e) {
				echo "Damn. Couldn't add user to database.";
				exit;
			}

			header("Location:" . BASE_URL . "dashboard/");
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
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
				<?php if (strlen($message)>70) : ?>
					<p class="error error--long"><?php echo $message; ?></p>
				<?php elseif (strlen($message)>1) : ?>
					<p class="message message--error"><?php echo $message; ?></p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>jobs/post.php">
					<p class="message message--hint">Psst. Make your job titles as descriptive as possible - it will avoid confusion in the Connectd community.</p>
					<input type="text" name="jobtitle" placeholder="Job title" value="<?php if (isset($jobtitle)) { echo htmlspecialchars($jobtitle); } ?>" required="required">
					<div class="float-left field-1-2">
						<label for="">Start date:</label>
						<input type="date" name="startdate" placeholder="Start date" value="<?php if (isset($startdate)) { echo htmlspecialchars($startdate); } ?>" required="required">
					</div>
					<div class="float-right field-1-2">
						<label for="">Deadline: (if applicable)</label>
						<input type="date" name="deadline" placeholder="Deadline" value="<?php if (isset($deadline)) { echo htmlspecialchars($deadline); } ?>">
					</div>
					<div class="float-left field-1-2">
						<input type="text" name="budget" placeholder="Minimum budget" value="<?php if (isset($budget)) { echo htmlspecialchars($budget); } ?>" required="required">
					</div>
					<div class="float-right field-1-2">
						<div class="select-container">
							<select name="jobcategory" required="required">
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
					</div>			
					<textarea name="jobdescription" cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!' required="required"><?php if (isset($jobdescription)) { echo htmlspecialchars($jobdescription); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Submit job'>						
					</div>
				</form> 
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>