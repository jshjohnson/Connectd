<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	include_once(ROOT_PATH . "inc/functions.php");
	require_once(ROOT_PATH . "inc/phpmailer/class.phpmailer.php");

	checkLoggedIn();

	$pageTitle = "Sign Up";
	$section = "Developer";
	include_once(ROOT_PATH . "views/header.php");

	// Grab the form data
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
	$age = trim($_POST['age']);
	$jobtitle = trim($_POST['jobtitle']);
	$experience = trim($_POST['experience']);
	$priceperhour = trim($_POST['priceperhour']);
	$bio = trim($_POST['bio']);
	$portfolio = trim($_POST['portfolio']);
	$location = trim($_POST['location']);
	$submit = trim($_POST['submit']);

	$status = $_GET["status"];

	// Mail validation using PHPMailer
	$mail = new PHPMailer(); // defaults to using php "mail()"

	$s_username = '';

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		$s_username = $_SESSION['email'];
		$errors[] = "You are already logged in as <b>$s_username</b>. Please <a href='" . BASE_URL . "inc/logout.php'>logout</a> before trying to register.";
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

		#validating user's input with functions that we will create next
		if ($users->email_exists($email) === true) {
		    $errors[] = 'That username already exists';
		}else if($firstname == ""){
		    $errors[] ="Please enter your first name"; 
		}else if($lastname == ""){
		    $errors[] ="Please enter your last name"; 
		}else if($email == ""){
		    $errors[] ="Please enter your email"; 
		}else if (!$mail->ValidateAddress($email)){
				$errors[] = "You must specify a valid email address.";
		}else if ($users->email_exists($email) === true) {
		    $errors[] = "Email already taken. Please try again.";
		}else if($password == ""){
		    $errors[] ="Please enter a password"; 
		}else if ($password!=$repeatpassword){ 
			$errors[] = "Both password fields must match";
		} else if(preg_match_all($r1,$password)<1) {
			$errors[] = "Your password needs to contain at least one uppercase character";
		} else if(preg_match_all($r2,$password)<1) {
			$errors[] = "Your password needs to contain at least one lowercase character";
		} else if(preg_match_all($r3,$password)<1) {
			$errors[] = "Your password needs to contain at least one number";
		} else if (strlen($password)>25||strlen($password)<6) {
			$errors[] = "Password must be 6-25 characters long";
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

			$firstname = clean_string($db, $firstname);
			$lastname = clean_string($db, $lastname);
			$email = clean_string($db, $email);
			$password = clean_string($db, $password);
			$repeatpassword = clean_string($db, $repeatpassword);
			$age = clean_string($db, $age);
			$jobtitle = clean_string($db, $jobtitle);
			$priceperhour = clean_string($db, $priceperhour);
			$bio = clean_string($db, $bio);
			$portfolio = clean_string($db, $portfolio);
			$experience = clean_string($db, $experience);
			$jobtitle = clean_string($db, $jobtitle);
	 
			$users->registerDev($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $age, $priceperhour, $experience, $bio);// Calling the register function, which we will create soon.
			header("Location:" . BASE_URL . "developer/signup.php?status=success");
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
					<?php include_once(ROOT_PATH . "views/page-nav.php"); ?>
				<?php endif; ?>
			<h2 class="header__section header__section--logo">
				<a href="<?php echo BASE_URL; ?>">connectd</a>
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
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">
				<?php 
					# if there are errors, they would be displayed here.
					if(empty($errors) === false){
						echo '<p class="error">' . implode('</p><p>', $errors) . '</p>';
					}
				?>
				<?php if ($status == "success") : ?>
				<p class="success">Thank you for registering. Please check your emails to active your account.</p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>developer/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" >
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>" >
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>" >
					<input type='password' name='password' placeholder="Password" class="field-1-2"  value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right"  value="<?php if (isset($repeatpassword)) { echo htmlspecialchars($repeatpassword); } ?>">
					<label for="jobtitle">Where do you work from?</label>
					<div class="select-container">
					<?php 
						require_once(ROOT_PATH . "inc/db_connect.php"); 
						$db_server = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
						$query = ("SELECT county FROM " . DB_NAME . ".locations ORDER BY county ASC");
						$result = mysqli_query($db_server, $query);
					?>
						<select name="location">
							<option value="">Location...</option>
						<?php while($row = mysqli_fetch_array($result)) : ?>
							<option <?php if ($_POST['location'] == $row['county']) { ?>selected="true" <?php }; ?>value="<?php echo $row['county']; ?>"><?php echo $row['county']; ?></option>
						<?php endwhile; ?>
						</select>
					</div>
					<input type="portfolio" name="portfolio" placeholder="Portfolio URL" value="<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>" >
					<label for="jobtitle">What best describes what you do?</label>
					<div class="select-container">
						<select name="jobtitle">
							<option value="">Pick one..</option>
							<option <?php if ($_POST['jobtitle'] == 'Web Developer') { ?>selected="true" <?php }; ?>value="Web Developer">Web Developer</option>
							<option <?php if ($_POST['jobtitle'] == 'Front-end Developer') { ?>selected="true" <?php }; ?>value="Front-end Developer">Front-end Developer</option>
							<option <?php if ($_POST['jobtitle'] == 'Front-end Engineer') { ?>selected="true" <?php }; ?>value="Front-end Engineer">Front-end Engineer</option>
							<option <?php if ($_POST['jobtitle'] == 'Back-end Developer') { ?>selected="true" <?php }; ?>value="Back-end Developer">Back-end Developer</option>
							<option <?php if ($_POST['jobtitle'] == 'Full Stack Developer') { ?>selected="true" <?php }; ?>value="Front-end Engineer">Full Stack Developer</option>
							<option <?php if ($_POST['jobtitle'] == 'Javascript Engineer') { ?>selected="true" <?php }; ?>value="Javascript Engineer">Javascript Engineer</option>
						</select>
					</div>
					<input type="number" name="age" placeholder="Age" min="18" max="80" class="field-1-2 float-left" value="<?php if (isset($age)) { echo htmlspecialchars($age); } ?>">
					<input type="number" name="priceperhour" placeholder="Price per hour" min="1" max="200" class="field-1-2 float-right"  value="<?php if (isset($priceperhour)) { echo htmlspecialchars($priceperhour); } ?>">
					<div class="select-container">
						<select name="experience">
							<option value="">Years experience...</option>
							<option <?php if ($_POST['experience'] == 'Less than 1 year') { ?>selected="true" <?php }; ?>value="Less than 1 year">Less than 1 year</option>
							<option <?php if ($_POST['experience'] == 'Between 1-2 years') { ?>selected="true" <?php }; ?>value="Between 1-2 years">Between 1-2 years</option>
							<option <?php if ($_POST['experience'] == 'Between 3-5 years') { ?>selected="true" <?php }; ?>value="Between 3-5 years">Between 3-5 years</option>
							<option <?php if ($_POST['experience'] == 'Between 5-10 years') { ?>selected="true" <?php }; ?>value="Between 5-10 years">Between 5-10 years</option>
							<option <?php if ($_POST['experience'] == 'Over 10 years') { ?>selected="true" <?php }; ?>value="Over 10 years">Over 10 years</option>
						</select>
					</div>
					<textarea name="bio" cols="30" rows="8" placeholder="A little about you..." ><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Apply for your place'>				
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>