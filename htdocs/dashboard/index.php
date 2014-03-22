<?php
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();
	// $votes->userVotedForProtect();

	$pageTitle    = "Dashboard";
	$section      = "Dashboard";

	include_once(ROOT_PATH . "includes/header.inc.php");

	$designers    = $designers->get_designers_all();
	$developers   = $developers->get_developers_all();
	$employers    = $employers->get_employers_all();
	$jobs         = $jobs->get_jobs_all();

	if (isset($_GET["status"])) { 
		$status = $_GET["status"];
	}
?>
	<?php if($status == "firstvisit") : ?>
		<section class="call-to-action call-to-action--top">
			<div class="container">
				<h4 class="as-h1 call-to-action__title zero-top">
					Welcome <?= $user[0]; ?>!
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL . $userType . "s/" . $user_id . "/" ?>">Build your profile</a>
			</div>
		</section>
	<? endif;?>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-left">
					<header class="header--panel header--designer cf">
						<h3 class="float-left"><a href="<?= BASE_URL; ?>designers/list/">Designers</a></h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php if (is_array($designers)) : ?>

						<?php foreach($designers as $designer_id => $designer) {
							include('../views/designer_list_view.php');
						} ?>

						<?php endif; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left"><a href="<?= BASE_URL; ?>developers/list/">Developers</a></h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php if (is_array($developers)) : ?>

						<?php foreach($developers as $developer_id => $developer) {
							include('../views/developer_list_view.php');
						} ?>

						<?php endif; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-left">
					<header class="header--panel header--employer cf">
						<h3 class="float-left"><a href="<?= BASE_URL; ?>employers/list/">Employers</a></h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php if (is_array($employers)) : ?>

						<?php foreach($employers as $employer_id => $employer) {
							include('../views/employer_list_view.php');
						} ?>

						<?php endif; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--employer cf">
						<h3 class="float-left"><a href="<?= BASE_URL; ?>jobs/list.php">My Jobs</a></h3>
						<?php if($userType == 'employer') : ?>
						<a href="<?= BASE_URL; ?>jobs/post.php" class="float-right btn btn--action">Post Job</a>
						<?php endif; ?>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php if (is_array($jobs)) : ?>

						<?php foreach($jobs as $job_id => $job) {
							include('../views/job_list_view.php');
						} ?>

						<?php endif; ?>
					</div>
				</article>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>