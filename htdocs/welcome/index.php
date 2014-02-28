<?php 	
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->loggedOutProtect();

	$pageTitle = "Trials";
	$section = "Trials";

	$user = $users->userData($_SESSION['id']);
	$username = $user[0] . " " . $user[1];

	$trial_users 		= $users->getTrialUsers();
	$trial_users_count   = count($members);

	include_once(ROOT_PATH . "inc/header-home.php");
?>
	<div class="welcome-intro">
		<h2 class="logo text-right"><a href="<?php echo BASE_URL; ?>">connectd</a></h2>
		<?php if (isset($_SESSION['logged'])) : ?>
			<h2 class="text-left"><a href="<?= BASE_URL ?>sign-out.php">Logout</a></h2>
		<?php else : ?>
		<h2 class="text-left"><a href="" class="login-trigger">Login</a></h2>
		<?php endif; ?>
		<section class="welcome-message">
			<div class="container">
				<h4 class="as-h1 welcome-message__title">
					Hey <?php echo $user[0]; ?>!
				</h4>
				<p>Welcome to Connectd. You have successfully signed up and have therefore been added to the Connectd Trials where the community will decide whether you are of a good enough quality to be hired. We will email you to update you on your progress in the Trials and whether you have achieved a vote.</p>
				<p>Good luck!</p>
				<p>You currently have <span class="vote-count">5</span> votes</p>
			</div>
		</section>
	</div>
<?php include_once(ROOT_PATH . "inc/footer-home.php"); ?>