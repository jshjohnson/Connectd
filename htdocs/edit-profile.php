<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

	$pageTitle = "Edit Profile";
	$pageType = "Page";
	$section = "Blue";
	include_once(ROOT_PATH . "includes/header.inc.php");

?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Edit Profile
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
		        <?php }; ?>
				<form action="" autocomplete="off">
					<div class="grid">
						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">Avatar</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
							<input type="file" name="file" id="file">
							</div>
						</fieldset>

						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">First name</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<input type="text" name="firstname" placeholder="First name" value="<?= $user['firstname'] ?>" autofocus>
							</div>
						</fieldset>

						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">Last name</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<input type="text" name="lastname" placeholder="Last name" value="<?= $user['lastname'] ?>" autofocus>
							</div>
						</fieldset>

						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">Bio</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<textarea name="bio" cols="30" rows="8" placeholder="A little about you..."><?= $user['bio'] ?></textarea>
							</div>
						</fieldset>

						<div class="button-container">
			            	<input class="submit" name="submit" type="submit" value='Update profile'>				
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>