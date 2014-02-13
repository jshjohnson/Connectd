<?php 
	require_once("../../config.php"); 
	include_once(ROOT_PATH . "inc/functions.php"); 

	checkLoggedOut();

	include_once(ROOT_PATH . "model/jobs.php");

	$jobs = get_jobs_all();
	$job_id = $_GET["id"];
	$job = $jobs[$job_id];

	$s_username = $_SESSION['username'];

	$pageTitle = $job['jobtitle'];
	$section = "Jobs";
	
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");

?>		
		<section class="container">
			<div class="grid--no-marg cf">
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
							<li class="active">Job Details</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
						<?php echo $job['budget']; ?>
						<?php echo $job['jobcategory']; ?>
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
				<aside class="grid__cell module-1-3 module--no-pad user-sidebar--employer float-right">
					<article class="user-sidebar module module--no-pad">
						<div class="user-sidebar__info">
							<h3 class="user-sidebar__title">Mixd</h3>
							<h4 class="user-sidebar__label icon--attach icon--marg">Digital Design Agency</h4>
							<h4 class="user-sidebar__label icon--location icon--marg">Harrogate, UK</h4>
							<h4 class="user-sidebar__label icon--globe icon--marg"><a href="">mixd.co.uk</a></h4>
							<p>
								We create beautifully-crafted websites that stand out from the crowd – and perfect function comes as standard.
							</p>
							<p>
								Our success is not only due to the quality of our work; it's down to attitude, our approach and the way we treat our clients.
							</p>
						</div>
					</article>
					<aside class="dashboard-panel module module--no-pad">
						<header class="header--panel header--employer cf">
							<h3 class="float-left">Freelancers who have applied</h3>
						</header>
						<div class="module--half-pad">
							<a href=""><img src="<?php echo BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?php echo BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?php echo BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?php echo BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?php echo BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?php echo BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?php echo BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
						</div>
					</aside>
				</aside>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Not the job for you?
				</h4>
				<button class="button-green"><a href="<?php echo BASE_URL; ?>jobs/list.php">See our jobs list</a></button>
			</div>
		</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>
