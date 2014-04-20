<?php 	
	require("../config.php");
	require(ROOT_PATH . "core/init.php");
	
	$debug->showErrors();
	$users->loggedOutProtect();

	$pageTitle = "Search";
	$pageType = "";
	$section = "Blue";

	include(ROOT_PATH . "includes/header.inc.php");

	$searchTerm = "";

	if(isset($_GET['search'])) {
		$searchTerm = trim($_GET['search']);
		if($searchTerm != "") {
			$allFreelancers = $search->getFreelancersSearch($searchTerm, $sessionUserID);
		}
	}
?>		
	<section class="call-to-action call-to-action--search">
		<div class="container call-to-action__container">
			<form action="<?= BASE_URL; ?>search/" class="zero-bottom">
				<input type="search" name="search" placeholder="Search for employers/jobs" value="<?php if (isset($searchTerm)) { echo htmlspecialchars($searchTerm); } ?>" results="5" class="call-to-action__search">
			</form>
		</div>
	</section>
	<section class="container footer--push">
		<div class="grid--no-marg text-center cf">
			<article class="dashboard-panel grid__cell module-2-3 module--no-pad">
				<header class="header--panel header--blue cf">
					<h3 class="float-left"><a href="<?= BASE_URL; ?>list.php?usertype=designer">New Freelancers</a></h3>
					<h4 class="float-right icon--users"></h4>
				</header>
				<div class="media-wrapper">
					<?php if (!empty($allFreelancers) && is_array($allFreelancers)) : ?>

					<?php foreach ($allFreelancers as $freelancer) {
						$userType = $freelancer['user_type'];
						include('../views/freelancer/freelancer-list.html');
					} ?>

					<?php else : ?>
						<?php include('../views/freelancer/star-empty-list.html'); ?>
					<?php endif;?>
				</div>
			</article>
		</div>
	</section>
<?php include(ROOT_PATH . "includes/footer.inc.php"); ?>