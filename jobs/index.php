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
				<article class="portfolio grid__cell module-2-3 module--no-pad float-left">
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active">Job Title</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
						<h4><?php echo $job['jobtitle']; ?></h4>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active">Job Description</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
						<?php echo $job['jobdescription']; ?>
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
