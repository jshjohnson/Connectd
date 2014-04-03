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
	<?php
		if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
			?>	
			<h3>Thanks, please check your email to confirm your request for a new password.</h3>
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
			?>
		    <h2>Recover Username / Password</h2>
		    <p>Enter your email below so we can confirm your request.</p>
		    <hr />
 
			<form action="" method="post">
				<ul>
					<li>
						<input type="text" required name="email">
					</li>
					<li><input type="submit" value="Recover"></li>
				</ul>
			</form>
			<?php	
		}
	?>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>