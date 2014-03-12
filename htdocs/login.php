<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

	$pageTitle = "Log in";
	include_once(ROOT_PATH . "inc/header.php");

	$status = $_GET["status"];

	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {
 
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$submit = trim($_POST['submit']);
		$remember = trim($_POST['remember']);
		$year = time() + 31536000;

		// If remember has been checked, set a cookie
		if($remember) {
			setcookie('remember_me', $email, $year);
		} elseif(!$remember) {
			if(isset($_COOKIE['remember_me'])) {
				$past = time() - 100;
				setcookie(remember_me, gone, $past);
			}
		}
 
		if (empty($email) === true || empty($password) === true) {
			$errors[] = 'Sorry, but we need your username and password.';
		} else if ($users->emailExists($email) === false) {
			$errors[] = 'Sorry that username doesn\'t exists.';
		} else if ($users->emailConfirmed($email) === false) {
			$errors[] = 'Uh oh! Looks like your account hasn\'t been activated yet. <a href="">Resend confirmation email</a>' ;
		} else {
	 
			$login = $users->login($email, $password);

			if ($login === false) {
				$errors[] = 'Sorry, that username/password is invalid';
			}else{
				// username/password is correct and the login method of the $users object returns the user's id, which is stored in $login.
	 
	 			session_regenerate_id(true);// destroying the old session id and creating a new one
	 			$_SESSION['user_id'] =  $login; // The user's id is now set into the user's session  in the form of $_SESSION['id'] 
				$_SESSION['logged']="logged";

				header('Location: dashboard/');
				
				// if($votes->userVotedFor($email) === true) {
				// 	#Redirect the user to the dashboard
				// 	header('Location: dashboard/');
				// 	exit();
				// } else {
				// 	header('Location: welcome/');
				// 	exit();
				// }

			}
		}
	} 
?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
			<h1 class="header__section header__section--title">
				Log In<a href="index.php#register" class="header__section--title__link"> : Register
			</h1>
			<h2 class="header__section header__section--logo">
				<a href="<?= BASE_URL; ?>">connectd</a>
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
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
			<?php if (isset($_GET['success']) === true && empty ($_GET['success']) === true)  { ?>
	        <p class="message message--success">Thank you, we've activated your account. You're free to log in!</p>
	        <?php } else if (isset ($_GET['email'], $_GET['email_code']) === true) {
		            
			    $email 		= trim($_GET['email']);
			    $email_code	= trim($_GET['email_code']);

				if ($users->emailExists($email) === false) {
					$errors[] = 'Sorry, we couldn\'t find that email address.';
				} else if ($users->activateUser($email, $email_code) === false) {
					$errors[] = 'Sorry, we couldn\'t activate your account.';
				}
	            
			    if(!empty($errors) === false){
	                header('Location: login.php?status=activated');
	                exit();
	            }
	        
		        } else if ($status == "logged") : ?>
				<p class="message message--success">Successfully logged out - see you soon!</p>
				<?php elseif($status == "activated") : ?>
				<p class="message message--success">Successfully activated account. Welcome to Connectd!</p>
				<?php endif; ?>
				<?php 
					# if there are errors, they would be displayed here.
					if(empty($errors) === false){
						echo '<p class="message message--error">' . implode('</p><p>', $errors) . '</p>';
					}
				?>
				<form method="post" action="login.php" autocomplete="off">
					<input type="email" name="email" placeholder="Email" value="<?php if(isset($_COOKIE['remember_me'])) { echo $_COOKIE['remember_me']; } else if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" class="field-1-2">
					<input type='password' name='password' placeholder="Password" class="field-1-2 float-right">
					<fieldset class="checkbox float-left">
						<label>Remember me</label>
							<input type="checkbox" value="1" name="remember" 
								<?php if(isset($_COOKIE['remember_me'])) {
									echo 'checked="checked"';
								}?>>
			        </fieldset>
			       	<a class="forgot float-right" href="recover-pass.php">Forgot password?</a>
					<div class="button-container clear">
		            	<input class="submit" name="submit" type="submit" value='Sign In'>					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>