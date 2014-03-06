<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 

	$general->loggedOutProtect();

	include_once(ROOT_PATH . "model/jobs.php");

	if (isset($_GET["id"])) {
		$job_id = $_GET["id"];
		$job = get_jobs_single($job_id);
	}

	if (empty($job)) {
		header("Location: " . BASE_URL);
		exit();
	}

	$pageTitle = $job['job_name'];
	$section = "Jobs";
	
	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/page-header.php");

?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<article class="portfolio grid__cell module-2-3 module--no-pad float-left">
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active">Job Title</li>
							<li class="float-right portfolio__headings--label"><?= $job['job_category']; ?></li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
						<h4><?= $job['job_name']; ?></h4>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active">Job Details</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
						<?= $job['job_budget']; ?>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active">Job Description</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
						<?= $job['job_description']; ?>
					</div>
				</article>
				<aside class="grid__cell module-1-3 module--no-pad user-sidebar--employer float-right">
					<article class="user-sidebar module module--no-pad">
						<div class="user-sidebar__info">
							<h3 class="user-sidebar__title"><a href="<?= BASE_URL . $job['user_type'] . "s/" . $job['user_id'] . "/" ?>"><?= $job['employer_name']; ?></a></h3>
							<h4 class="user-sidebar__label icon--attach icon--marg"><?= $job['employer_type']; ?></h4>
							<h4 class="user-sidebar__label icon--location icon--marg"><?= $job['location']; ?></h4>
							<h4 class="user-sidebar__label icon--globe icon--marg"><a href="<?= $job['portfolio']; ?>"><?= $job['portfolio']; ?></a></h4>
							<p><?= $job['bio']; ?></p>
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
				<a class="btn button-green" href="<?= BASE_URL; ?>jobs/list.php">See our jobs list</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>
