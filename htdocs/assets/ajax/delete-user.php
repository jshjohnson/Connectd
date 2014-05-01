<?php
	require("../../config.php");
	require(ROOT_PATH . "core/init.php");
?>
<section class="overlay">
	<div class="overlay__inner overlay__inner--small">
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class="overlay__title">Are you sure?</h2>
		<p class="overlay__caption">This action cannot be reversed.</p>
		<div class="btn-wrapper">
			<a href="<?= BASE_URL; ?>settings/delete-user.php?user_id=<?= $sessionUserID; ?>" class="btn btn--red btn--small">Delete account</a>
		</div>
	</div>
</section>