<?php
	require_once("../inc/config.php"); 
	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/functions.php");

	// Grab the form data
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
	$age = trim($_POST['age']);
	$jobtitle = trim($_POST['jobtitle']);
	$experience = trim($_POST['experience']);
	$bio = trim($_POST['bio']);
	$portfolio = trim($_POST['portfolio']);
	$submit = trim($_POST['submit']);

	// Create some variables to hold output data
	$message = '';
	$s_username = '';

	// Start to use PHP session
	session_start();
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		$s_username = $_SESSION['email'];
		$message = "You are already logged in as <b>$s_username</b>. Please <a href='logout.php'>logout</a> before trying to register.";
	}else{
		if ($submit=='Apply for your place'){
				
		    if($firstname == ""){
		        $message="Please enter your first name"; 
		    }else if($lastname == ""){
		        $message="Please enter your last name"; 
		    }else if($email == ""){
		        $message="Please enter your email"; 
		    }else if($password == ""){
		        $message="Please enter a password"; 
		    }else if ($password!=$repeatpassword){ 
				$message = "Both password fields must match";
			}else if (strlen($password)>25||strlen($password)<6) {
				$message = "Password must be 6-25 characters long";
			}else if($jobtitle == ""){
		        $message="Please select your current job title"; 
		    }else if($experience == ""){
		        $message="Please enter your experience"; 
		    }else if($bio == ""){
		        $message="Please write about yourself"; 
		    }else if(strlen($bio)<25) {
				$message = "You're not going to sell yourself without a decent bio!";
			}else{
				// Process details here
				require_once(ROOT_PATH . "inc/db_connect.php"); //include file to do db connect
				if($db_server){

					//clean the input now that we have a db connection
					$firstname = clean_string($db_server, $firstname);
					$lastname = clean_string($db_server, $lastname);
					$email = clean_string($db_server, $email);
					$password = clean_string($db_server, $password);
					$repeatpassword = clean_string($db_server, $repeatpassword);
					$age = clean_string($db_server, $age);
					$jobtitle = clean_string($db_server, $jobtitle);
					$bio = clean_string($db_server, $bio);
					$portfolio = clean_string($db_server, $portfolio);
					$experience = clean_string($db_server, $experience);

					mysqli_select_db($db_server, $db_database);

					// check whether email has been used before
					$query="SELECT designers.email FROM connectdDB.designers WHERE designers.email='$email' UNION SELECT developers.email FROM connectdDB.developers WHERE developers.email='$email' UNION SELECT employers.email FROM connectdDB.employers WHERE employers.email='$email'";
					$result = mysqli_query($db_server, $query);
					if ($row = mysqli_fetch_array($result)){
						$message = "Email already taken. Please try again.";
					}else{
						// Encrypt password
						$password = salt($password);
						$query = "INSERT INTO connectdDB.developers (firstname, lastname, email, password, portfolio, jobtitle, age, experience, bio) VALUES ('$firstname', '$lastname', '$email', '$password', '$portfolio', '$jobtitle', '$age', '$experience', '$bio')";
						mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
						header("Location:" . BASE_URL . "sign-in.php");
					}
					mysqli_free_result($result);
				}else{
					$message = "Error: could not connect to the database.";
				}
				require_once(ROOT_PATH . "inc/db_close.php"); 
			}

		}
	}

?>
	<header class="header header-navy--alt zero-bottom cf">
		<div class="container">
			<h1 class="page-title">
				Sign Up<a href="" class="login-trigger page-title__link"> : Log In</a>
			</h1>
			<h2 class="page-logo header-logo">
				<a href="<?php echo BASE_URL; ?>">connectd</a>
			</h2>
		</div>
	</header>
	<section>
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
				<?php if (strlen($message)>70) : ?>
					<p class="error error--long"><?php echo $message; ?></p>
				<?php elseif (strlen($message)>1) : ?>
					<p class="error"><?php echo $message; ?></p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>developer/signup.php" autocomplete="off">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>">
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<input type='password' name='password' placeholder="Password" class="field-1-2">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right">
					<input type="portfolio" name="portfolio" placeholder="Portfolio URL" value="<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>">
					<label for="jobtitle">What best describes what you do?</label>
					<div class="select-container">
						<select name="jobtitle">
							<option value="">Pick one..</option>
							<option value="Web Developer">Web Developer</option>
							<option value="Front-end Developer">Front-end Developer</option>
							<option value="Front-end Engineer">Front-end Engineer</option>
							<option value="Back-end Developer">Back-end Developer</option>
							<option value="Full stack Developer">Full Stack Developer</option>
						</select>
					</div>
					<input type="number" name="age" placeholder="Age" min="18" max="80" class="field-1-2 float-left" value="<?php if (isset($age)) { echo htmlspecialchars($age); } ?>">
					<input type="number" name="experience" placeholder="Years Experience" min="1" max="50" class="field-1-2 float-right" value="<?php if (isset($experience)) { echo htmlspecialchars($experience); } ?>">
					<textarea name="bio" cols="30" rows="10" placeholder="A little about you..."><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Apply for your place'>					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>
