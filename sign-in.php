<?php
include_once("inc/header.php");
include_once("inc/functions.php"); 
include_once("inc/errors.php"); 
include_once("inc/login.php");
?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
			<h1 class="page-title">
				Sign In<a href="index.php" class="page-title__link"> : Register
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
				<?php if (strlen($message)>1) : ?>
					<p class="error"><?php echo $message; ?></p>
				<?php endif; ?>
				<form method="post" action="sign-in.php" autocomplete="off">
					<input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" class="field-1-2">
					<input type='password' name='password' placeholder="Password" class="field-1-2 float-right">
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Sign In'>					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once("inc/footer.php"); ?>