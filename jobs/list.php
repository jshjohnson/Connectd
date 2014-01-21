<?php 
	require_once("../config/config.php");
	include_once(ROOT_PATH . "inc/functions.php"); 

	checkLoggedOut();

	include_once(ROOT_PATH . "model/jobs.php");

	$section = "Jobs";

	$jobs = get_jobs_all();
	$job_id = $_GET["id"];
	$job = $jobs[$job_id];

	$s_username = $_SESSION['username'];
	
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-sidebar grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
				</aside>
				<article class="dashboard-panel grid__cell module-2-3 module--no-pad">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">My Jobs</h3>
						<a href="<?php echo BASE_URL; ?>post/"><button class="float-right button-action">Post Job</button></a>
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
				<button class="button-red"><a href="<?php echo BASE_URL; ?>search/">See our talented bunch</a></button>
			</div>
		</section>
<?php include_once(ROOT_PATH . "views/footer-page.php"); ?>
