<?php 	
	require_once("../config/config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle = "Settings";
	$section = "Page";
	
	$general->loggedOutProtect();

	include_once(ROOT_PATH . "includes/header.inc.php");
?>  
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Settings
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp4 unit-2-3--bp1 content-overlay">
				<?php if(empty($errors) === false) : ?>
					<p class="message message--error shake"><?= implode('</p><p>', $errors); ?></p>
				<?php endif; ?>
				<?php if ($status == "success") : ?>
				<p class="message message--success fadeIn">Thank you for registering. Please check your emails to activate your account.</p>
				<?php endif; ?>
				<form method="post" action="<?= BASE_URL; ?>designers/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="Update first name" class="field-1-2" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" autofocus>
					<input type="text" name="lastname" placeholder="Update surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Update email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Update Settings'>
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
