<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedInProtect();
	$counties = $general->getCounties();

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
	$businesstype = trim($_POST['businesstype']);
	$businesswebsite = trim($_POST['businesswebsite']);
	$businessbio = trim($_POST['businessbio']);
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
			$businesswebsite = $general->cleanString($db, $businesswebsite);
			$businessbio = $general->cleanString($db, $businessbio);


			$employers->registerEmployer($firstname, $lastname, $email, $password, $businessname, $location, $businesstype, $businesswebsite, $businessbio);
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
				<?php 
					if(empty($errors) === false){
						echo '<p class="message message--error">' . implode('</p><p>', $errors) . '</p>';
					}
				?>
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
					<input type="text" name="businessname" placeholder="Business name" value="<?php if (isset($businessname)) { echo htmlspecialchars($businessname); } ?>">
					<label for="jobtitle">What is the location of your business?</label>
					<div class="select-container">
						<select name="location">
							<option value="">Location...</option>
						<?php foreach ($counties as $county) : ?>
							<option <?php if ($_POST['location'] == $county['county']) { ?>selected="true" <?php }; ?>value="<?php echo $county['county']; ?>"><?php echo $county['county']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<label for="jobtitle">What industry is your business in?</label>
					<div class="select-container">
						<select name="businesstype">
							<option value="">Pick one..</option>
							<option <?php if ($_POST['businesstype'] == 'Admin') { ?>selected="true" <?php }; ?>value="Admin">Admin</option>
							<option <?php if ($_POST['businesstype'] == 'Business Support') { ?>selected="true" <?php }; ?>value="Business Support">Business Support</option>
							<option <?php if ($_POST['businesstype'] == 'Creative Arts') { ?>selected="true" <?php }; ?>value="Creative Arts">Creative Arts</option>
							<option <?php if ($_POST['businesstype'] == 'Design') { ?>selected="true" <?php }; ?>value="Design">Design</option>
							<option <?php if ($_POST['businesstype'] == 'Marketing &amp; PR') { ?>selected="true" <?php }; ?>value="Marketing &amp; PR">Marketing &amp; PR</option>
							<option <?php if ($_POST['businesstype'] == 'Mobile') { ?>selected="true" <?php }; ?>value="Mobile">Mobile</option>
							<option <?php if ($_POST['businesstype'] == 'Search Marketing') { ?>selected="true" <?php }; ?>value="Search Marketing">Search Marketing</option>
							<option <?php if ($_POST['businesstype'] == 'Social Media') { ?>selected="true" <?php }; ?>value="Social Media">Social Media</option>
							<option <?php if ($_POST['businesstype'] == 'Software Development') { ?>selected="true" <?php }; ?>value="Software Development">Software Development</option>
							<option <?php if ($_POST['businesstype'] == 'Translation') { ?>selected="true" <?php }; ?>value="Translation">Translation</option>
							<option <?php if ($_POST['businesstype'] == 'Tutorials') { ?>selected="true" <?php }; ?>value="Tutorials">Tutorials</option>
							<option <?php if ($_POST['businesstype'] == 'Video, Photo &amp; Audio') { ?>selected="true" <?php }; ?>value="Video, Photo &amp; Audio">Video, Photo &amp; Audio</option>
							<option <?php if ($_POST['businesstype'] == 'Web Development') { ?>selected="true" <?php }; ?>value="Web Development">Web Development</option>
							<option <?php if ($_POST['businesstype'] == 'Copywriting') { ?>selected="true" <?php }; ?>value="Copywriting">Copywriting</option>
							<option <?php if ($_POST['businesstype'] == 'Extraordinary') { ?>selected="true" <?php }; ?>value="Extraordinary">Extraordinary</option>
						</select>
					</div>
					<input type="text" name="businesswebsite" placeholder="Business website" value="<?php if (isset($businesswebsite)) { echo htmlspecialchars($businesswebsite); } ?>">
					<textarea name="businessbio" cols="30" rows="8" placeholder="A little about your business..." ><?php if (isset($businessbio)) { echo htmlspecialchars($businessbio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Start employing'>						
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>