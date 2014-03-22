<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedInProtect();

	$towns             = $users->getLocations();
	$experiences       = $users->getExperiences();

	$userType          = "Designer";
	$jobTitles         = $freelancers->getFreelancerJobTitles($userType);

	$pageTitle         = "Sign Up";
	$pageType          = "Page";
	$section           = "Blue";
	
	include_once(ROOT_PATH . "includes/header.inc.php");

	// Grab the form data
	$firstName         = trim($_POST['firstname']);
	$lastName          = trim($_POST['lastname']);
	$email             = trim($_POST['email']);
	$password          = trim($_POST['password']);
	$repeatPassword    = trim($_POST['repeatpassword']);
	$jobTitle          = trim($_POST['jobtitle']);
	$experience        = trim($_POST['experience']);
	$pricePerHour      = trim($_POST['priceperhour']);
	$bio               = trim($_POST['bio']);
	$portfolio         = trim($_POST['portfolio']);
	$location          = trim($_POST['location']);
	$submit            = trim($_POST['submit']);

	$status = $_GET["status"];

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {

		$general->hijackPrevention();

     	$r1='/[A-Z]/';  // Test for an uppercase character
       	$r2='/[a-z]/';  // Test for a lowercase character
		$r3='/[0-9]/';  // Test for a number

		if($firstName == ""){
		    $errors[] ="Please enter your first name";
		}else if($lastName == ""){
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
		} else if($jobTitle == ""){
		    $errors[] ="Please select your current job title";
		}else if($experience == ""){
		    $errors[] ="Please enter your experience";
		}else if($bio == ""){
		    $errors[] ="Please write about yourself";
		}else if(strlen($bio)<25) {
			$errors[] = "You're not going to sell yourself without a decent bio!";
		}

		if(empty($errors) === true){

			$firstName      = $general->cleanString($db, $firstName);
			$lastName       = $general->cleanString($db, $lastName);
			$email          = $general->cleanString($db, $email);
			$password       = $general->cleanString($db, $password);
			$repeatPassword = $general->cleanString($db, $repeatPassword);
			$location       = $general->cleanString($db, $location);
			$jobTitle       = $general->cleanString($db, $jobTitle);
			$pricePerHour   = $general->cleanString($db, $pricePerHour);
			$bio            = $general->cleanString($db, $bio);
			$portfolio      = $general->cleanString($db, $portfolio);
			$experience     = $general->cleanString($db, $experience);
			$userType       = 'designer';

			$freelancers->registerFreelancer($firstName, $lastName, $email, $password, $location, $portfolio, $jobTitle, $pricePerHour, $experience, $bio, $userType);
			header("Location:" . BASE_URL . "designers/signup.php?status=success");
			exit();
		}
	}
?>
	<section>
		<div class="section-heading color-blue">
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
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp4 unit-2-3--bp1 content-overlay">
				<?php if(empty($errors) === false) : ?>
					<p class="message message--error"> <?= implode('</p><p>', $errors); ?></p>
				<?php endif; ?>
				<?php if ($status == "success") : ?>
				<p class="message message--success">Thank you for registering. Please check your emails to activate your account.</p>
				<?php endif; ?>
				<form method="post" action="<?= BASE_URL; ?>designers/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2" value="<?php if (isset($firstName)) { echo htmlspecialchars($firstName); } ?>" autofocus>
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastName)) { echo htmlspecialchars($lastName); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<p class="message message--hint">Psst. Passwords must contain at least one uppercase character and at least one number.</p>
					<input type='password' name='password' placeholder="Password" class="field-1-2"  value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right"  value="<?php if (isset($repeatPassword)) { echo htmlspecialchars($repeatPassword); } ?>">
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
						<input type="text" name="portfolio" placeholder="Portfolio URL" class="input--url" value="<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>" >
					</div>
					<div class="select-container">
						<select name="jobtitle">
							<option value="">Job title..</option>
							<?php foreach ($jobTitles as $jobTitle) : ?>
								<option <?php if ($_POST['jobtitle'] == $jobTitle) { ?>selected="true" <?php }; ?>value="<?= $jobTitle; ?>"><?= $jobTitle; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="select-container field-1-2 float-left">
						<select name="experience">
							<option value="">Years experience...</option>
							<?php foreach ($experiences as $experience) : ?>
								<option <?php if ($_POST['experience'] == $experience) { ?>selected="true" <?php }; ?>value="<?= $experience; ?>"><?= $experience; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="currency-container field-1-2 float-right">
						<span class="currency-prepend">£</span>
						<input type="number" name="priceperhour" placeholder="Price per hour" min="1" max="1000" class="input--currency" value="<?php if (isset($pricePerHour)) { echo htmlspecialchars($pricePerHour); } ?>">
					</div>
					<textarea name="bio" cols="30" rows="8" placeholder="A little about you..."><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Apply for your place'>
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
