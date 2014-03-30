<?php
	require_once("../../config/config.php");
	require_once(ROOT_PATH . "core/init.php");
	
	$userFirstName = $_SESSION["userFirstName"];
	$userEmail = $_SESSION["userEmail"]; 
?>
<section class="overlay">
	<div class="overlay__inner overlay__inner--mid">
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class='overlay__title'>Show them what you are made of...</h2>
		<form method="post" action="<?= BASE_URL; ?>message.php" autocomplete="off">
			<textarea name='message' id='' cols='30' rows='15' placeholder='Write anything here that you think the employer would appreciate knowing about yourself. The more detailed, the better!'></textarea>
			<div class='btn-container'>
				<input class='btn--green' type='submit' value='Send'>
			</div>
		</form> 
	</div>
</section>