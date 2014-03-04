<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedInProtect();

	$counties = $general->getCounties();
	$businessTypes = $general->getBusinessTypes();

	$pageTitle = "Sign Up";
	$section = "Employer";
	include_once(ROOT_PATH . "inc/header.php");

	// Grab the form data
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
	$businessname = trim($_POST['businessname']);
	$location = trim($_POST['location']);
	$experience = trim($_POST['experience']);
	$businesstype = trim($_POST['businesstype']);
	$portfolio = trim($_POST['portfolio']);
	$bio = trim($_POST['bio']);
	$submit = trim($_POST['submit']);

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
   			 $errors[]  = "You must specify a valid email address.";
		}else if ($users->emailExists($email) === true) {
		    $errors[] = "Email already taken. Please try again.";
		}else if($password == ""){
	        $errors[] ="Please enter a password"; 
	    }else if ($password!=$repeatpassword){ 
			$errors[]  = "Both password fields must match";
		}else if(preg_match_all($r1,$password)<1) {
			$errors[]  = "Your password needs to contain at least one uppercase character";
		}else if(preg_match_all($r2,$password)<1) {
			$errors[]  = "Your password needs to contain at least one lowercase character";
		}else if(preg_match_all($r3,$password)<1) {
			$errors[]  = "Your password needs to contain at least one number";
		}else if (strlen($password)>25||strlen($password)<6) {
			$errors[]  = "Password must be 6-25 characters long";
		}else if($businessname == ""){
	        $errors[]  = "Please enter your business name"; 
	    }else if($businesstype == ""){
	        $errors[]  = "Please enter your business type"; 
	    }else if($experience == ""){
		    $errors[] ="Please enter your experience";
		}else if($businessbio == ""){
	        $errors[]  = "Please write about your business"; 
	    }else if(strlen($businessbio)<25) {
			$errors[]  = "Freelancers require a bit more information about your business!";
		}

		if(empty($errors) === true) {

			//clean the input now that we have a db connection
			$firstname = $general->cleanString($db, $firstname);
			$lastname = $general->cleanString($db, $lastname);
			$email = $general->cleanString($db, $email);
			$password = $general->cleanString($db, $password);
			$repeatpassword = $general->cleanString($db, $repeatpassword);
			$businessname = $general->cleanString($db, $businessname);
			$location = $general->cleanString($db, $location);
			$businesstype = $general->cleanString($db, $businesstype);
			$portfolio = $general->cleanString($db, $website);
			$experience = $general->cleanString($db, $experience);
			$bio = $general->cleanString($db, $bio);
			$votes = '100';
			$user_type = 'employer';


			$employers->registerUser($firstname, $lastname, $email, $password, $businessname, $location, $businesstype, $portfolio, $experience, $bio, $user_type, $votes);
			header("Location:" . BASE_URL . "employers/signup.php?status=success");
			exit();
		}

	}
?>
	<header class="header header-green--alt zero-bottom cf">
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
				<form method="post" action="<?php echo BASE_URL; ?>employers/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" autofocus>
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<p class="message message--hint">Psst. Passwords must contain at least one uppercase character and at least one number.</p>
					<input type='password' name='password' placeholder="Password" class="field-1-2"  value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right"  value="<?php if (isset($repeatpassword)) { echo htmlspecialchars($repeatpassword); } ?>">
					<hr>
					<input type="text" name="businessname" placeholder="Business name" value="<?php if (isset($businessname)) { echo htmlspecialchars($businessname); } ?>">
					<input type="url" name="portfolio" placeholder="Business website" value="<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>">
					<div class="select-container">
						<label for="location">What is the location of your business?</label>
						<select name="location">
							<option value="">Location...</option>
						<?php foreach ($counties as $county) : ?>
							<option <?php if ($_POST['location'] == $county['county']) { ?>selected="true" <?php }; ?>value="<?php echo $county['county']; ?>"><?php echo $county['county']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<div class="select-container field-1-2 float-left">
						<label for="businesstype">What industry is your business in?</label>
						<select name="businesstype">
							<option value="">Pick one..</option>
							<?php foreach ($businessTypes as $businessType) : ?>
								<option <?php if ($_POST['businesstype'] == $businessType['business_type']) { ?>selected="true" <?php }; ?>value="<?php echo $businessType['business_type']; ?>"><?php echo $businessType['business_type']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="select-container field-1-2 float-right">
						<label for="experience">How long have you been in business for?</label>
						<select name="experience">
							<option value="">Years experience...</option>
							<option <?php if ($_POST['experience'] == 'Less than 1 year') { ?>selected="true" <?php }; ?>value="Less than 1 year">Less than 1 year</option>
							<option <?php if ($_POST['experience'] == 'Between 1-2 years') { ?>selected="true" <?php }; ?>value="Between 1-2 years">Between 1-2 years</option>
							<option <?php if ($_POST['experience'] == 'Between 3-5 years') { ?>selected="true" <?php }; ?>value="Between 3-5 years">Between 3-5 years</option>
							<option <?php if ($_POST['experience'] == 'Between 5-10 years') { ?>selected="true" <?php }; ?>value="Between 5-10 years">Between 5-10 years</option>
							<option <?php if ($_POST['experience'] == 'Over 10 years') { ?>selected="true" <?php }; ?>value="Over 10 years">Over 10 years</option>
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
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>