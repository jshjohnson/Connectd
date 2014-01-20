<?php
	require_once("config/config.php"); 
	include_once(ROOT_PATH . "inc/errors.php");

	$pageTitle = "Sign in";
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "inc/functions.php"); 
	include_once(ROOT_PATH . "inc/login.php");
	$status = $_GET["status"];
?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
			<h1 class="header__section header__section--title">
				Sign In<a href="index.php" class="header__section--title__link"> : Register
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
				<?php if ($status == "logged") : ?>
				<p class="success">Successfully logged out - see you soon!</p>
				<?php elseif($status == "registered") : ?>
				<p class="success">Welcome to Connectd! - Sign in below</p>
				<?php endif; ?>
				<?php if (strlen($message)>1) : ?>
					<p class="error"><?php echo $message; ?></p>
				<?php endif; ?>
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