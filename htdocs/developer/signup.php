<?php
	require_once("../../config.php");
	include_once(ROOT_PATH . "inc/functions.php");
	require_once(ROOT_PATH . "inc/phpmailer/class.phpmailer.php");

	checkLoggedIn();

	$pageTitle = "Sign Up";
	$section = "Developer";
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "inc/functions.php");

	// Grab the form data
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
	$age = trim($_POST['age']);
	$jobtitle = trim($_POST['jobtitle']);
	$priceperhour = trim($_POST['priceperhour']);
	$experience = trim($_POST['experience']);
	$bio = trim($_POST['bio']);
	$portfolio = trim($_POST['portfolio']);
	$location = trim($_POST['location']);
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
		$s_username = $_SESSION['email'];
		$message = "You are already logged in as <b>$s_username</b>. Please <a href='" . BASE_URL . "logout.php'>logout</a> before trying to register.";
	}else{
		if ($submit=='Apply for your place'){

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
				require_once(ROOT_PATH . "inc/db_connect.php"); 

				//clean the input now that we have a db connection
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

				try {
					$result = $db->prepare("SELECT designers.email 
						FROM connectdDB.designers 
						WHERE designers.email = ? 
						UNION SELECT developers.email 
						FROM connectdDB.developers 
						WHERE developers.email = ?
						UNION SELECT employers.email 
						FROM connectdDB.employers 
						WHERE employers.email = ?
					");
					$result->bindParam(1, $email);
					$result->bindParam(2, $email);
					$result->bindParam(3, $email);
					$result->execute();

					$total = $result->rowCount();
					$row = $result->fetch();
				
				} catch (Exception $e) {
					echo "Damn. Data could not be retrieved.";
					exit;
				}

				// check whether email has been used before
				if ($total > 0) {
					$message = "Email already taken. Please try again.";
				}else{
					// Encrypt password
					$password = salt($password);

					try {
						$result = $db->prepare("INSERT INTO connectdDB.developers 
							(firstname, lastname, email, password, location, portfolio, jobtitle, age, priceperhour, experience, bio, datejoined) 
							VALUES 
							(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())");
						$result->bindParam(1, $firstname);
						$result->bindParam(2, $lastname);
						$result->bindParam(3, $email);
						$result->bindParam(4, $password);
						$result->bindParam(5, $location);
						$result->bindParam(6, $portfolio);
						$result->bindParam(7, $jobtitle);
						$result->bindParam(8, $age);
						$result->bindParam(9, $priceperhour);
						$result->bindParam(10, $experience);
						$result->bindParam(11, $bio);
						$result->execute();
					
					} catch (Exception $e) {
						echo "Damn. Couldn't add user to database.";
						exit;
					}
					
					header("Location:" . BASE_URL . "sign-in.php?status=registered");
				} 
			}
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
				<?php if (strlen($message)>106) : ?>
					<p class="error error--long"><?php echo $message; ?></p>
				<?php elseif (strlen($message)>1) : ?>
					<p class="error"><?php echo $message; ?></p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>developer/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" required="required">
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>" required="required">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>" required="required">
					<input type='password' name='password' placeholder="Password" class="field-1-2" required="required" value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right" required="required" value="<?php if (isset($repeatpassword)) { echo htmlspecialchars($repeatpassword); } ?>">
					<label for="jobtitle">Where do you work from?</label>
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
					<input type="portfolio" name="portfolio" placeholder="Portfolio URL" value="<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>" required="required">
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
					<input type="number" name="priceperhour" placeholder="Price per hour" min="1" max="200" class="field-1-2 float-right"  value="<?php if (isset($priceperhour)) { echo htmlspecialchars($priceperhour); } ?>">
					<div class="select-container">
						<select name="experience">
							<option value="">Years experience...</option>
							<option value="Less than 1 year">Less than 1 year</option>
							<option value="Between 1-2 years">Between 1-2 years</option>
							<option value="Between 3-5 years">Between 3-5 years</option>
							<option value="Between 5-10 years">Between 5-10 years</option>
							<option value="Over 10 years">Over 10 years</option>
						</select>
					</div>
					<textarea name="bio" cols="30" rows="8" placeholder="A little about you..." required="required"><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Apply for your place' disabled="disabled">				
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>