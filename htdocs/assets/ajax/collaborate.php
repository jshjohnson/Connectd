<?php
	require_once("../../config/config.php");
	require_once(ROOT_PATH . "core/init.php");
	
	$userFirstName = $_SESSION["userFirstName"];
	$userEmail = $_SESSION["userEmail"]; 
?>
<section class="overlay">
	<div class="overlay__inner overlay__inner--mid"> 
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class='overlay__title'>The key to creativity is collaboration...</h2>
		<form method="post" action="<?= BASE_URL; ?>message.php" autocomplete="off">
			<input type="text" name="firstname" class="is-hidden" value="<?= $userFirstName; ?>">
			<input type="email" name="email" class="is-hidden" value="<?= $userEmail; ?>">
			<textarea name='message' id='' cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!'></textarea>
			<div class='button-container'>
				<input class='btn--green' type='submit' value='Send'>
			</div>
		</form> 
	</div>
</section>