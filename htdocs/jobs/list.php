<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 

	$general->loggedOutProtect();

	include_once(ROOT_PATH . "model/jobs.php");

	$section     = "Jobs";

	$jobs        = get_jobs_all();
	$job_id      = $_GET["id"];
	$job         = $jobs[$job_id];

	$user        = $users->userData($_SESSION['id']);
	$username    = $user[0] . " " . $user[1];
	
	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/page-header.php");
?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-sidebar grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">Search</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
					</div>
				</aside>
				<article class="dashboard-panel grid__cell module-2-3 module--no-pad float-left">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">My Jobs</h3>
						<a href="<?= BASE_URL; ?>post/"><button class="float-right btn--action">Post Job</button></a>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php foreach($jobs as $job_id => $job) {
							echo get_job_list_view($job_id, $job);
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
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>
