<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedInProtect();

	$towns              = $general->getLocations();
	$employerTypes      = $general->getEmployerTypes();
	$experiences        = $general->getExperiences();

	$pageTitle          = "Sign Up";
	$pageType           = "Page";
	$section            = "Green";

	include_once(ROOT_PATH . "includes/header.inc.php");

	// Grab the form data
	$firstname          = trim($_POST['firstname']);
	$lastname           = trim($_POST['lastname']);
	$email              = trim($_POST['email']);
	$password           = trim($_POST['password']);
	$repeatpassword     = trim($_POST['repeatpassword']);
	$employerName       = trim($_POST['employer_name']);
	$employerType       = trim($_POST['employer_type']);
	$location           = trim($_POST['location']);
	$experience         = trim($_POST['experience']);
	$portfolio          = trim($_POST['portfolio']);
	$bio                = trim($_POST['bio']);
	$submit             = trim($_POST['submit']);

	$status = $_GET["status"];
	
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {

		$general->hijackPrevention();

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
   			 $errors[]  = "You must specify a valid email address.";
		}else if ($users->emailExists($email) === true) {
		    $errors[] = "Email already taken. Please try again.";
		}else if($password == ""){
	        $errors[] ="Please enter a password"; 
	    }else if ($password!=$repeatpassword){ 
			$errors[]  = "Both password fields must match";
		}else if(preg_match_all($r1,$password, $o)<1) {
			$errors[]  = "Your password needs to contain at least one uppercase character";
		}else if(preg_match_all($r2,$password, $o)<1) {
			$errors[]  = "Your password needs to contain at least one lowercase character";
		}else if(preg_match_all($r3,$password, $o)<1) {
			$errors[]  = "Your password needs to contain at least one number";
		}else if (strlen($password)>25||strlen($password)<6) {
			$errors[]  = "Password must be 6-25 characters long";
		}else if($employerName == ""){
	        $errors[]  = "Please enter your business name"; 
	    }else if($employerType == ""){
	        $errors[]  = "Please enter your business type"; 
	    }else if($experience == ""){
		    $errors[] ="Please enter your experience";
		}else if($bio == ""){
	        $errors[]  = "Please write about your business"; 
	    }else if(strlen($bio)<25) {
			$errors[]  = "Freelancers require a bit more information about your business!";
		}

		if(empty($errors) === true) {

			//clean the input now that we have a db connection
			$firstname          = $general->cleanString($db, $firstname);
			$lastname           = $general->cleanString($db, $lastname);
			$email              = $general->cleanString($db, $email);
			$password           = $general->cleanString($db, $password);
			$repeatpassword     = $general->cleanString($db, $repeatpassword);
			$employerName       = $general->cleanString($db, $employerName);
			$location           = $general->cleanString($db, $location);
			$employerType       = $general->cleanString($db, $employerType);
			$portfolio          = $general->cleanString($db, $portfolio);
			$experience         = $general->cleanString($db, $experience);
			$bio                = $general->cleanString($db, $bio);
			$userType          = 'employer';


			$users->registerEmployer($firstname, $lastname, $email, $password, $location, $portfolio, $employerName, $employerType, $experience, $bio, $userType);
			header("Location:" . BASE_URL . "employers/signup.php?status=success");
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
							Let's talk business...
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
					<p class="message message--error"> <?= implode('</p><p>', $errors); ?></p>
				<?php endif; ?>
				<?php if ($status == "success") : ?>
				<p class="message message--success">Thank you for registering. Please check your emails to activate your account.</p>
				<?php endif; ?>
				<form method="post" action="<?= BASE_URL; ?>employers/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" autofocus>
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<p class="message message--hint">Psst. Passwords must contain at least one uppercase character and at least one number.</p>
					<input type='password' name='password' placeholder="Password" class="field-1-2"  value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right"  value="<?php if (isset($repeatpassword)) { echo htmlspecialchars($repeatpassword); } ?>">
					<hr>
					<input type="text" name="employer_name" placeholder="Employer name" value="<?php if (isset($employerName)) { echo htmlspecialchars($employerName); } ?>">
					<div class="url-container">
						<span class="url-prepend">http://</span>
						<input type="text" name="portfolio" placeholder="Employer website" class="input--url" value="<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>">
					</div>
					<div class="select-container">
						<label for="location">What is the location of your business?</label>
						<select name="location">
							<option value="">Location...</option>
						<?php foreach ($towns as $town) : ?>
							<option <?php if ($_POST['location'] == $town['town']) { ?>selected="true" <?php }; ?>value="<?= $town['town']; ?>"><?= $town['town']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<div class="select-container field-1-2 float-left">
						<label for="employer_type">What industry is your business in?</label>
						<select name="employer_type">
							<option value="">Pick one..</option>
							<?php foreach ($employerTypes as $employerType) : ?>
								<option <?php if ($_POST['employer_type'] == $employerType) { ?>selected="true" <?php }; ?>value="<?= $employerType; ?>"><?= $employerType; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="select-container field-1-2 float-right">
						<label for="experience">How long have you been in business for?</label>
						<select name="experience">
							<option value="">Years experience...</option>
							<?php foreach ($experiences as $experience) : ?>
								<option <?php if ($_POST['experience'] == $experience) { ?>selected="true" <?php }; ?>value="<?= $experience; ?>"><?= $experience; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<textarea name="bio" cols="30" rows="8" placeholder="A little about your company..."><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Start employing'>						
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>