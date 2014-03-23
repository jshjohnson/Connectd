<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");
	
	$general->errors();
	$general->loggedOutProtect();

	if (isset($_GET["id"])) {
		$employer_id       = $_GET["id"];
		$employer          = $employers->get_employers_single($employer_id);
		$jobs              = $employers->getEmployerJobs($employer_id);
	}

	if (empty($employer)) {
		header("Location: " . BASE_URL);
		exit();
	}
	
	$pageTitle     = "Employer";
	$section       = "Employers";

	include_once(ROOT_PATH . "includes/header.inc.php");
?>	
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="float-left grid__cell module-1-3 module--no-pad user-module--employer">
					<article class="user-module module module--no-pad">
						<div class="user-module__info">
							<?php  if(strtotime(date('F j, Y', $employer['time_joined']))>strtotime('-3 days')) : ?>
							     <div class="ribbon"><h5>New</h5></div>
							<?php endif ?>
							<?php 
								$employerName = $employer['employer_name'];

								if (strlen($employerName)>=23) {
									echo "<h3 class=\"user-module__title user-module__title--alt\">" . $employerName . "</h3>";
								} else {
									echo "<h3 class=\"user-module__title\">" . $employerName . "</h3>";
								}
							?>
							<h4 class="user-module__label icon--attach icon--marg"><?= $employer['employer_type']; ?></h4>
							<h4 class="user-module__label icon--location icon--marg"><?= $employer['location']; ?></h4>
							<h4 class="user-module__label icon--globe icon--marg"><a href="<?= $employer['portfolio']; ?>"><?= $employer['portfolio']; ?></a></h4>
							<p><?= $employer['bio']; ?></p>
						</div>
					</article>
					<aside class="dashboard-panel module module--no-pad">
						<header class="header--panel header--employer cf">
							<h3 class="float-left">Worked with</h3>
						</header>
						<div class="module--half-pad">
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
						</div>
					</aside>
				</aside>
				<aside class="dashboard-panel grid__cell module-2-3 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Current jobs</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
					<?php if (!empty($jobs)) : ?>
					<?php foreach($jobs as $job) { ?>
						<?php 
							$budget = $job['job_budget'];
							$jobName = $job['job_name']
							?>
						<div class="media">
							<div class="media__desc media-2-3 media-2-3--wide">
								<div class="media__button badge__inner-button">
									<span class="badge__inner">
										<?php if ($budget>=10000) {
												echo "£" . substr($budget, 0, 2) . "k";
											} elseif ($budget>=1000) {
												echo "£" . substr($budget, 0, 1) . "k";
											} else {
												echo "£" . $budget;
											}
										?>
									</span>
								</div>
								<a href="<?= BASE_URL . "jobs/" . $job['job_id'] . "/"; ?>"><p class="media__body">
										<?php if ($jobName>=150) {
												echo substr($jobName, 0, 150) . "...";
											} else {
												echo $jobName;
											}
										?>
								</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small><?= date('F j, Y', $job['job_post_date']); ?></small></p>
								<a class="btn btn--green btn--small apply-trigger" href="<?= BASE_URL . "jobs/" . $job['job_id']; ?>">Apply</a>
							</div>
						</div>
					<?php }; ?>
					<?php else : ?>
						<div class="media media--blank">
							<div class="media__desc media-2-3">
								<p class="media__body">
								<?= $employer['employer_name']; ?> has not posted a job yet. Try checking back later!
								</p>
							</div>
						</div>
					<?php endif;?>
					</div>
				</aside>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for freelance work?
				</h4>
				<a class="btn btn--green" href="<?= BASE_URL; ?>dashboard/">See our jobs list</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
