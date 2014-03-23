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
					<?php include('../views/employer-sidebar.view.html'); ?>
				</aside>
				<aside class="dashboard-panel grid__cell module-2-3 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Current jobs</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
					<?php if (!empty($jobs)) : ?>
					<?php foreach($jobs as $job) { ?>
						<?php include('../views/job-list.view.html'); ?>
					<?php }; ?>
					<?php else : ?>
						<?php include('../views/job-empty-list.view.html'); ?>
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
