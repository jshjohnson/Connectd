<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

	$pageTitle = "Account Settings";
	$pageType = "Page";
	$section = "Designers";
	include_once(ROOT_PATH . "includes/header.inc.php");

?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Account Settings
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
				<form action=""  autocomplete="off">
					<div class="grid">
						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">First name</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<input type="text" name="firstname" placeholder="<?= $user['firstname']; ?>" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" autofocus>
							</div>
						</fieldset>

						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">Last name</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<input type="text" name="lastname" placeholder="<?= $user['lastname']; ?>" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>" autofocus>
							</div>
						</fieldset>

						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">Email address</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<input type="email" name="email" placeholder="<?= $user['email']; ?>" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
							</div>
						</fieldset>

						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">New password</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<input type='password' name='password' placeholder="• • • • • • • •" value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
							</div>
						</fieldset>

						<fieldset>
							<div class="grid__cell unit-1-3--bp2">
								<label for="firstname">Repeat password</label>
							</div>
							<div class="grid__cell unit-2-3--bp2">
								<input type='password' name='repeatpassword' placeholder="• • • • • • • •" value="<?php if (isset($repeatpassword)) { echo htmlspecialchars($repeatpassword); } ?>">
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