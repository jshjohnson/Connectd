<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$debug->showErrors();

	$pageTitle = "Recover password";
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
							Recover Password
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
    		<?php if (isset($_GET['success']) === true && empty ($_GET['success']) === true) { ?>
            	<p class="message message--success fadeIn">Thank you, we've sent you a randomly generated password in your email.</p>
            <?php } else if (isset ($_GET['email'], $_GET['generated_string']) === true) {
            
					$email = trim($_GET['email']);
					$string = trim($_GET['generated_string']);	

					if ($users->emailExists($email) === false || $users->recover($email, $string) === false) {
						$errors[] = 'Sorry, something went wrong and we couldn\'t recover your password.';
					}

					if (empty($errors) === false) {    		
						echo '<p class="message message--error shake">' . implode('</p><p>', $errors) . '</p>';
					} else {
						#redirect the user to recover.php?success if recover() function does not return false.
						header('Location: recover.php?success');
						exit();
					}

					} else {
						header('Location: index.php'); // If the required parameters are not there in the url. redirect to index.php
						exit();
					}
		       ?>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>