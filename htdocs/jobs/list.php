<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php"); 

	$users->loggedOutProtect();

	$section     = "Jobs";
	$pageTitle   = "Job search";

	$jobs        = $jobs->getJobsAll();
	$job_id      = $_GET["id"];
	$job         = $jobs[$job_id];
	
	include(ROOT_PATH . "includes/header.inc.php");
?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-module grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">Search</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
					</div>
				</aside>
				<article class="dashboard-panel grid__cell module-2-3 module--no-pad float-left">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">Jobs</h3>
						<?php if($sessionUserType == 'employer') : ?>
						<a href="<?= BASE_URL; ?>jobs/post.php" class="float-right btn btn--action">Post Job</a>
						<?php endif; ?>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php foreach($jobs as $job_id => $job) {
							include('../views/job-list.html');
						} ?>
					</div>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for someone else?
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL; ?>designers/list/">See our talented bunch</a>
			</div>
		</section>
<?php include(ROOT_PATH . "includes/footer.inc.php"); ?>
