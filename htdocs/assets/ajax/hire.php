<?php
	require("../../config.php");
	require(ROOT_PATH . "core/init.php");
	
	$userFirstName = $_SESSION["userFirstName"];
	$userEmail = $_SESSION["userEmail"]; 
?>
<section class="overlay">
	<div class='overlay__inner overlay__inner--mid'>
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class="overlay__title"> You’re one message away...</h2>
		<form method="post" action="<?= BASE_URL; ?>message.php" autocomplete="off">
			<input type="text" name="firstname" class="is-hidden" value="<?= $userFirstName; ?>">
			<input type="email" name="email" class="is-hidden" value="<?= $userEmail; ?>">
			<textarea name='message' cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!'></textarea>
			<div class='btn-container'>
				<input class="btn btn--green" type='submit' value='Send'>
			</div>
		</form> 
	</div>
</section>