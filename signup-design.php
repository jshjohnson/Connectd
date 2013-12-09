<?php
//Register form validation
include_once("inc/header.php");
include_once("inc/functions.php");

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
$submit = trim($_POST['submit']);

// Create some variables to hold output data
$message = '';
$s_username = '';

// Start to use PHP session
session_start();
// Determine whether user is logged in - test for value in $_SESSION
if (isset($_SESSION['logged'])){
	$s_username = $_SESSION['email'];
	$message = "You are already logged in as $s_username. Please <a href='logout.php'>logout</a> before trying to register.";
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
			require_once("inc/db_connect.php"); //include file to do db connect
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
				$experience = clean_string($db_server, $experience);

				mysqli_select_db($db_server, $db_database);

				// check whether email has been used before
				$query="SELECT email FROM connectdDB.designers WHERE email='$email'";
				$result = mysqli_query($db_server, $query);
				if ($row = mysqli_fetch_array($result)){
					$message = "Email already taken. Please try again.";
				}else{
					// Encrypt password
					$password = salt($password);
					$query = "INSERT INTO connectdDB.designers (firstname, lastname, email, password, jobtitle, age, experience, bio) VALUES ('$firstname', '$lastname', '$email', '$password', '$jobtitle', '$age', '$experience', '$bio')";
					mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
					header('Location: sign-in.php');
				}
				mysqli_free_result($result);
			}else{
				$message = "Error: could not connect to the database.";
			}
			require_once("inc/db_close.php"); //include file to do db close
		}

	}
}



?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
			<h1 class="page-title">
				Sign Up<a href="" class="login-trigger page-title__link"> : Log In
			</h1>
			<h2 class="page-logo header-logo">
				<a href="index.php">connectd</a>
			</h2>
		</div>
	</header>
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
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">
				<p><?php echo $message; ?></p>
				<form method="post" action="signup-design.php">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left">
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right">
					<input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
					<input type='password' name='password' placeholder="Password" class="field-1-2 float-left">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right">
					<input type="text" name="jobtitle" placeholder="Job Title">
					<input type="number" name="age" placeholder="Age" min="18" max="80" class="field-1-2 float-left">
					<input type="number" name="experience" placeholder="Years Experience" min="1" max="50" class="field-1-2 float-right">
					<textarea name="bio" cols="30" rows="10" placeholder="A little about you..."></textarea>
					<div class="button-container">
		            	<input id="submit" class="submit" name="submit" type="submit" value='Apply for your place'>					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once("inc/footer.php"); ?>