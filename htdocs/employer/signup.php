<?php
	require_once("../../config.php");
	include_once(ROOT_PATH . "inc/functions.php");
	require_once(ROOT_PATH . "inc/phpmailer/class.phpmailer.php");

	checkLoggedIn();

	$pageTitle = "Sign Up";
	$section = "Employer";
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "inc/functions.php");

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

	// Mail validation using PHPMailer
	$mail = new PHPMailer(); // defaults to using php "mail()"

	// Create some variables to hold output data
	$message = '';
	$s_username = '';

	// Start to use PHP session
	session_start();
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		$s_username = $_SESSION['firstname'];
		$message = "You are already logged in as $s_username. Please <a href='" . BASE_URL . "logout.php'>logout</a> before trying to register.";
	}else{
		if ($submit=='Start employing'){

			// Form hijack prevention
			foreach( $_POST as $value ){
	            if( stripos($value,'Content-Type:') !== FALSE ){
	                $message = "Hmmmm. Are you a robot? Try again.";
	            }
	        }
				
		    if($firstname == ""){
		        $message="Please enter your first name"; 
		    }else if($lastname == ""){
		        $message="Please enter your last name"; 
		    }else if($email == ""){
		        $message="Please enter your email"; 
		    }else if (!$mail->ValidateAddress($email)){
       			 $message = "You must specify a valid email address.";
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
				require_once(ROOT_PATH . "inc/db_connect.php"); //include file to do db connect
				$db_server = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
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

					mysqli_select_db($db_server, DB_NAME);

					// check whether email has been used before
					$query="SELECT designers.email FROM connectdDB.designers WHERE designers.email='$email' UNION SELECT developers.email FROM connectdDB.developers WHERE developers.email='$email' UNION SELECT employers.email FROM connectdDB.employers WHERE employers.email='$email'";
					$result = mysqli_query($db_server, $query);
					if ($row = mysqli_fetch_array($result)){
						$message = "Email already taken. Please try again.";
					}else{
						// Encrypt password
						$password = salt($password);
						$query = "INSERT INTO connectdDB.employers (firstname, lastname, email, password, businessname, businesstype, businesswebsite, businessbio, datejoined) VALUES ('$firstname', '$lastname', '$email', '$password', '$businessname', '$businesstype', '$businesswebsite', '$businessbio', now())";
						mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
						header("Location:" . BASE_URL . "sign-in.php?status=registered");
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
	<header class="header header-green--alt zero-bottom cf">
		<div class="container">
			<h1 class="header__section header__section--title">
				Sign Up<a href="" class="login-trigger header__section--title__link"> : Log In</a>
			</h1>
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
				<?php if (strlen($message)>106) : ?>
					<p class="error error--long"><?php echo $message; ?></p>
				<?php elseif (strlen($message)>1) : ?>
					<p class="error"><?php echo $message; ?></p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>employer/signup.php" autocomplete="off">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>">
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<input type='password' name='password' placeholder="Password" class="field-1-2 float-left">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right">
					<input type="text" name="businessname" placeholder="Business name" value="<?php if (isset($businessname)) { echo htmlspecialchars($businessname); } ?>">
					<label for="jobtitle">What is the location of your business?</label>
					<div class="select-container">
					<?php 
						require_once(ROOT_PATH . "inc/db_connect.php"); 
						$db_server = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
						$query = ("SELECT county FROM connectdDB.locations ORDER BY county ASC");
						$result = mysqli_query($db_server, $query);
					?>
						<select name="location">
						<?php while($row = mysqli_fetch_array($result)) : ?>
						  <option value="<?php echo $row['county']; ?>"><?php echo $row['county']; ?></option>
						<?php endwhile; ?>
						</select>
					</div>
					<label for="jobtitle">What industry is your business in?</label>
					<div class="select-container">
						<select name="businesstype">
							<option value="">Pick one..</option>
							<option value="Admin">Admin</option>
							<option value="Business Support">Business Support</option>
							<option value="Creative Arts">Creative Arts</option>
							<option value="Design">Design</option>
							<option value="Marketing &amp; PR">Marketing &amp; PR</option>
							<option value="Mobile">Mobile</option>
							<option value="Search Marketing">Search Marketing</option>
							<option value="Social Media">Social Media</option>
							<option value="Software Developer">Software Development</option>
							<option value="Translation">Translation</option>
							<option value="Tutorials">Tutorials</option>
							<option value="Video, Photo &amp; Audio">Video, Photo &amp; Audio</option>
							<option value="Web Development">Web Development</option>
							<option value="Copywriting">Copywriting</option>
							<option value="Extraordinary">Extraordinary</option>
						</select>
					</div>
					<input type="text" name="businesswebsite" placeholder="Business website" value="<?php if (isset($businesswebsite)) { echo htmlspecialchars($businesswebsite); } ?>">
					<textarea name="businessbio" cols="30" rows="8" placeholder="A little about your business..."><?php if (isset($businessbio)) { echo htmlspecialchars($businessbio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Start employing'>						
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>
