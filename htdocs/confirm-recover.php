<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

	$pageTitle = "Sign in";
	include_once(ROOT_PATH . "inc/header.php");
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
							Recover username/password
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
			<?php if (isset($_GET['success']) === true && empty($_GET['success']) === true) { ?>
					<p class="message message--success">Thanks, please check your email to confirm your request for a password.</p>
			<?php 
				} else {
					
					if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
						if ($users->email_exists($_POST['email']) === true){
							$users->confirm_recover($_POST['email']);
		 
							header('Location:confirm-recover.php?success');
							exit();
							
						} else { ?>
							<p class="message message--success">Thanks, please check your email to confirm your request for a password.</p>
					<?php
						}
					}
					?>
	 
					<form action="" method="post">
						<p class="message message--hint">Enter your email below so we can confirm your request.</p>
						<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>" required>
						<div class="button-container">
			            	<input class="submit" name="submit" type="submit" value='Recover'>				
						</div>
					</form>
					<?php	
				}
			?>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>