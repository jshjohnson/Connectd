<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

	$pageTitle = "Sign in";
	include_once(ROOT_PATH . "views/header.php");

	$status = $_GET["status"];

	if (isset($_POST['submit'])) {
 
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
 
		if (empty($email) === true || empty($password) === true) {
			$errors[] = 'Sorry, but we need your username and password.';
		} else if ($users->email_exists($email) === false) {
			$errors[] = 'Sorry that username doesn\'t exists.';
		} else if ($users->email_confirmed($email) === false) {
			$errors[] = 'Sorry, but you need to activate your account. Please check your emails.';
		} else {
	 
			$login = $users->login($email, $password);

			$db_name = $row['firstname'] . ' ' . $row['lastname'];
			$db_email = $row['email'];

			if ($login === false) {
				$errors[] = 'Sorry, that username/password is invalid';
			}else {
				// username/password is correct and the login method of the $users object returns the user's id, which is stored in $login.
	 
	 			$_SESSION['id'] =  $login; // The user's id is now set into the user's session  in the form of $_SESSION['id'] 
				$_SESSION['username'] = $db_name;
				$_SESSION['email']=$email;
				$_SESSION['logged']="logged";


				// If remember has been checked, set a cookie
				if($remember) {
					setcookie('remember_me', $email, $year);
				}
				
				#Redirect the user to the dashboard
				header('Location: dashboard/');
				exit();
			}
		}
	} 
?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
			<h1 class="header__section header__section--title">
				Sign In<a href="index.php#register" class="header__section--title__link"> : Register
			</h1>
			<h2 class="header__section header__section--logo">
				<a href="<?php echo BASE_URL; ?>">connectd</a>
			</h2>
		</div>
	</header>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Sign in
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">


			<?php if (isset($_GET['success']) === true && empty ($_GET['success']) === true)  { ?>
	        <p class="success">Thank you, we've activated your account. You're free to log in!</p>
	        <?php } else if (isset ($_GET['email'], $_GET['email_code'], $_GET['user']) === true) {
		            
			    $email 		= trim($_GET['email']);
			    $email_code	= trim($_GET['email_code']);

				if($_GET['user'] == "developer") {     
					if ($users->email_exists($email) === false) {
						$errors[] = 'Sorry, we couldn\'t find that email address.';
					} else if ($users->activateDeveloper($email, $email_code) === false) {
						$errors[] = 'Sorry, we couldn\'t activate your account.';
					}
				} else if($_GET['user'] == "designer") {     
					if ($users->email_exists($email) === false) {
						$errors[] = 'Sorry, we couldn\'t find that email address.';
					} else if ($users->activateDesigner($email, $email_code) === false) {
						$errors[] = 'Sorry, we couldn\'t activate your account.';
					}
				} else if($_GET['user'] == "employer") {     
					if ($users->email_exists($email) === false) {
						$errors[] = 'Sorry, we couldn\'t find that email address.';
					} else if ($users->activateEmployer($email, $email_code) === false) {
						$errors[] = 'Sorry, we couldn\'t activate your account.';
					}
				}
		            
			    if(!empty($errors) === false){
	                header('Location: sign-in.php?status=activated');
	                exit();
	            }
	        
		        } else if ($status == "logged") : ?>
				<p class="success">Successfully logged out - see you soon!</p>
				<?php elseif($status == "activated") : ?>
				<p class="success">Successfully activated account. Welcome to Connectd!</p>
				<?php endif; ?>
				<?php 
					# if there are errors, they would be displayed here.
					if(empty($errors) === false){
						echo '<p class="error">' . implode('</p><p>', $errors) . '</p>';
					}
				?>
				<form method="post" action="sign-in.php" autocomplete="off">
					<input type="email" name="email" placeholder="Email" value="<?php echo $_COOKIE['remember_me']; ?>" class="field-1-2">
					<input type='password' name='password' placeholder="Password" class="field-1-2 float-right">
					<fieldset class="checkbox float-left">
						<label>
							<input type="checkbox" value="1" name="remember" 
								<?php if(isset($_COOKIE['remember_me'])) {
									echo 'checked="checked"';
								}
								else {
									echo '';
								}
								?>>
							Remember me
						</label>
			        </fieldset>
			       	<a class="forgot float-right" href="#">Forgot password?</a>
					<div class="button-container clear">
		            	<input class="submit" name="submit" type="submit" value='Sign In'>					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>