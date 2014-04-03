<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

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
			<?php if (isset($_GET['success']) === true && empty($_GET['success']) === true) { ?>
				<p class="message message--success fadeIn">Thanks, please check your email to confirm your request for a new password.</p>
			<?php 
				} else {
			
					if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
						if ($users->emailExists($_POST['email']) === true){
							$users->confirmRecover($_POST['email']);
		 
							header('Location:confirm-recover.php?success');
							exit();
							
						} else {
							echo 'Sorry, that email doesn\'t exist.';
						}
					}
				}
			?>
				<form method="post" action="" autocomplete="off">
					<p class="message message--hint">Enter your email below so we can confirm your request.</p>
					<input type="email" name="email" placeholder="Email">
					<div class="btn-container clear">
		            	<input class="btn--green" name="submit" type="submit" value="Recover">					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>