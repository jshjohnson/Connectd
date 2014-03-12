<?php 	
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->loggedOutProtect();
	$userVotes = $votes->getUserVotes($user_id);

	$pageTitle = "Trials";
	$section = "Trials";

	include_once(ROOT_PATH . "inc/header-home.php");
?>
	<div class="welcome-intro">
		<h2 class="logo text-right"><a href="<?= BASE_URL; ?>">connectd</a></h2>
		<?php if (isset($_SESSION['logged'])) : ?>
			<h2 class="text-left"><a href="<?= BASE_URL ?>logout.php">Logout</a></h2>
		<?php else : ?>
		<h2 class="text-left"><a href="" class="login-trigger">Login</a></h2>
		<?php endif; ?>
		<section class="welcome-message">
			<div class="container">
				<h4 class="as-h1 welcome-message__title">
					Hey <?= $user['firstname']; ?>!
				</h4>
				<p>Welcome to Connectd. You have successfully signed up and have therefore been added to the Connectd Trials where the community will decide whether you are of a good enough quality to be hired. We will email you to update you on your progress in the Trials and whether you have achieved a vote.</p>
				<p>Good luck!</p>
				<p class="message-flipped message-flipped--notification">You currently have <strong><?= $userVotes['votes']; ?></strong>/10 votes</p>
			</div>
		</section>
	</div>
<?php include_once(ROOT_PATH . "inc/footer-home.php"); ?>