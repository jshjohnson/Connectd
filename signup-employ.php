<?php
//Register form validation
include_once("inc/header.php");
include_once("inc/functions.php");
include_once("inc/errors.php");

// Grab the form data
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$repeatpassword = trim($_POST['repeatpassword']);
$businessname = trim($_POST['businessname']);
$businesstype = trim($_POST['businesstype']);
$businesswebsite = trim($_POST['businesswebsite']);
$businessbio = trim($_POST['businessbio']);
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
	if ($submit=='Start employing'){
			
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
		}else if($businessname == ""){
	        $message="Please enter your business name"; 
	    }else if($businesstype == ""){
	        $message="Please enter your business type"; 
	    }else if($businessbio == ""){
	        $message="Please write about your business"; 
	    }else if(strlen($businessbio)<25) {
			$message = "Freelancers require a bit more information about your business!";
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

				$businessname = clean_string($db_server, $businessname);
				$businesstype = clean_string($db_server, $businesstype);
				$businesswebsite = clean_string($db_server, $businesswebsite);
				$businessbio = clean_string($db_server, $businessbio);

				$submit = trim($_POST['submit']);

				mysqli_select_db($db_server, $db_database);

				// check whether email has been used before
				$query="SELECT email FROM connectdDB.employers WHERE email='$email'";
				$result = mysqli_query($db_server, $query);
				if ($row = mysqli_fetch_array($result)){
					$message = "Email already taken. Please try again.";
				}else{
					// Encrypt password
					$password = salt($password);
					$query = "INSERT INTO connectdDB.employers (firstname, lastname, email, password, businessname, businesstype, businesswebsite, businessbio) VALUES ('$firstname', '$lastname', '$email', '$password', '$businessname', '$businesstype', '$businesswebsite', '$businessbio')";
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
	<header class="header header-green--alt zero-bottom cf">
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
		<div class="section-heading color-green">
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
				<p><?php echo $message; ?></p>
				<form method="post" action="signup-employ.php">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left">
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right">
					<input type="email" name="email" placeholder="Email">
					<input type='password' name='password' placeholder="Password" class="field-1-2 float-left">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right">
					<input type="text" name="businessname" placeholder="Business name">
					<select name="businesstype">
					  <option value="design">Design Agency</option>
					  <option value="digital">Digital Agency</option>
					  <option value="programming">Programming Agency</option>
					  <option value="programming">Sole Trader</option>
					</select>
					<input type="text" name="businesswebsite" placeholder="Business website">
					<textarea name="businessbio" cols="30" rows="10" placeholder="A little about your business..."></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Start employing'>						
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once("inc/footer.php"); ?>