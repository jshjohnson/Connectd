<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedInProtect();

	$towns = $general->getLocations();
	$experiences = $general->getExperiences();

	$userType = "Developer";
	$jobTitles = $general->getJobTitles($userType);

	$pageTitle = "Sign Up";
	$section = "Developer";

	include_once(ROOT_PATH . "inc/header.php");

	// Grab the form data
	$firstname         = trim($_POST['firstname']);
	$lastname          = trim($_POST['lastname']);
	$email             = trim($_POST['email']);
	$password          = trim($_POST['password']);
	$repeatpassword    = trim($_POST['repeatpassword']);
	$jobtitle          = trim($_POST['jobtitle']);
	$experience        = trim($_POST['experience']);
	$priceperhour      = trim($_POST['priceperhour']);
	$bio               = trim($_POST['bio']);
	$portfolio         = trim($_POST['portfolio']);
	$location          = trim($_POST['location']);
	$submit            = trim($_POST['submit']);

	$status = $_GET["status"];

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {

		// Form hijack prevention
		foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $errors[] = "Hmmmm. Are you a robot? Try again.";
            }
        }
	 		        
		$r1='/[A-Z]/';  // Test for an uppercase character
		$r2='/[a-z]/';  // Test for a lowercase character
		$r3='/[0-9]/';  // Test for a number

		if($firstname == ""){
		    $errors[] ="Please enter your first name"; 
		}else if($lastname == ""){
		    $errors[] ="Please enter your last name"; 
		}else if($email == ""){
		    $errors[] ="Please enter your email"; 
		}else if (!$mail->ValidateAddress($email)){
				$errors[] = "You must specify a valid email address.";
		}else if ($users->emailExists($email) === true) {
		    $errors[] = "Email already taken. Please try again.";
		}else if($password == ""){
		    $errors[] ="Please enter a password"; 
		}else if ($password!=$repeatpassword){ 
			$errors[] = "Both password fields must match";
		} else if(preg_match_all($r1,$password, $o)<1) {
			$errors[] = "Your password needs to contain at least one uppercase character";
		} else if(preg_match_all($r2,$password, $o)<1) {
			$errors[] = "Your password needs to contain at least one lowercase character";
		} else if(preg_match_all($r3,$password, $o)<1) {
			$errors[] = "Your password needs to contain at least one number";
		} else if (strlen($password)>25||strlen($password)<6) {
			$errors[] = "Password must be 6-25 characters long";
		} else if($portfolio == ""){
		    $errors[] ="You must have an active portfolio to join Connectd"; 
		} else if($jobtitle == ""){
		    $errors[] ="Please select your current job title"; 
		}else if($experience == ""){
		    $errors[] ="Please enter your experience"; 
		}else if($bio == ""){
		    $errors[] ="Please write about yourself"; 
		}else if(strlen($bio)<25) {
			$errors[] = "You're not going to sell yourself without a decent bio!";
		}

		if(empty($errors) === true){

			$firstname         = $general->cleanString($db, $firstname);
			$lastname          = $general->cleanString($db, $lastname);
			$email             = $general->cleanString($db, $email);
			$password          = $general->cleanString($db, $password);
			$repeatpassword    = $general->cleanString($db, $repeatpassword);
			$location          = $general->cleanString($db, $location);
			$jobtitle          = $general->cleanString($db, $jobtitle);
			$priceperhour      = $general->cleanString($db, $priceperhour);
			$bio               = $general->cleanString($db, $bio);
			$portfolio         = $general->cleanString($db, $portfolio);
			$experience        = $general->cleanString($db, $experience);
			$user_type         = 'developer';
	 
			$users->registerFreelancer($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $priceperhour, $experience, $bio, $user_type);
			header("Location:" . BASE_URL . "developers/signup.php?status=success");
			exit();
		}
	}
?>
	<header class="header header-navy--alt zero-bottom cf">
		<div class="container">
				<?php if (!isset($_SESSION['logged'])) :?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="login-trigger header__section--title__link">: Log In</a>
				</h1>
				<?php else : ?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="menu-trigger header__section--title__link">: Menu</a>
				</h1>
					<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				<?php endif; ?>
			<h2 class="header__section header__section--logo">
				<a href="<?= BASE_URL; ?>">connectd</a>
			</h2>
		</div>
	</header>
		<div class="section-heading color-navy">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							The beginning of something special...
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-grey">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp4 unit-2-3--bp1 content-overlay">
				<?php if(empty($errors) === false) : ?>
					<p class="message message--error"><?= implode('</p><p>', $errors); ?></p>
				<?php endif; ?>
				<?php if ($status == "success") : ?>
				<p class="message message--success">Thank you for registering. Please check your emails to activate your account.</p>
				<?php endif; ?>
				<form method="post" action="<?= BASE_URL; ?>developers/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" autofocus>
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<p class="message message--hint">Psst. Passwords must contain at least one uppercase character and at least one number.</p>
					<input type='password' name='password' placeholder="Password" class="field-1-2"  value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right"  value="<?php if (isset($repeatpassword)) { echo htmlspecialchars($repeatpassword); } ?>">
					<hr>
					<div class="select-container">
						<label for="location">Where do you work from?</label>
						<select name="location">
							<option value="">Location...</option>
						<?php foreach ($towns as $town) : ?>
							<option <?php if ($_POST['location'] == $town['town']) { ?>selected="true" <?php }; ?>value="<?= $town['town']; ?>"><?= $town['town']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<p class="message message--hint">Psst. Prospective users need an online portfolio to prove themselves in the Connectd community.</p>
					<div class="url-container">
						<span class="url-prepend">http://</span>
						<input type="text" name="portfolio" placeholder="Portfolio URL" class="input--url" value="http://<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>" >
					</div>
					<div class="select-container">
						<label for="jobtitle">What best describes what you do?</label>
						<select name="jobtitle">
							<option value="">Pick one..</option>
							<?php foreach ($jobTitles as $jobTitle) : ?>
								<option <?php if ($_POST['jobtitle'] == $jobTitle['job_title']) { ?>selected="true" <?php }; ?>value="<?= $jobTitle['job_title']; ?>"><?= $jobTitle['job_title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="select-container field-1-2 float-left">
						<select name="experience">
							<option value="">Years experience...</option>
							<?php foreach ($experiences as $experience) : ?>
								<option <?php if ($_POST['experience'] == $experience['experience']) { ?>selected="true" <?php }; ?>value="<?= $experience['experience']; ?>"><?= $experience['experience']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="currency-container field-1-2 float-right">
						<span class="currency-prepend">£</span>
						<input type="number" name="priceperhour" placeholder="Price per hour" min="1" max="1000" class="input--currency" value="<?php if (isset($priceperhour)) { echo htmlspecialchars($priceperhour); } ?>">
					</div>
					<textarea name="bio" cols="30" rows="8" placeholder="A little about you..."><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Apply for your place'>				
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>