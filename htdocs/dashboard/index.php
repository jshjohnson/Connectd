<?php
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->logged_out_protect();
	$general->errors();

	$pageTitle = "Dashboard";
	$section = "Dashboard";

	$user = $users->userdata($_SESSION['id']);
	$username = $user[0] . " " . $user[1];

	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/page-header.php");

	// User data
	require_once(ROOT_PATH . "model/designers.php");
	require_once(ROOT_PATH . "model/developers.php");
	require_once(ROOT_PATH . "model/jobs.php");

	$designers = get_designers_all();
	$developers = get_developers_all();
	$jobs = get_jobs_recent();


?>
		<section class="call-to-action call-to-action--top">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Welcome <?php echo $user[0]; ?>!
				</h4>
				<button class="button-red"><a href="<?php echo BASE_URL . "developer/profile.php?id=" . $_SESSION['userID']; ?>">Build your profile</a></button>
			</div>
		</section>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-left">
					<header class="header--panel header--designer cf">
						<h3 class="float-left"><a href="<?php echo BASE_URL; ?>designer/list.php">Designers</a></h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php if (is_array($designers)) : ?>

						<?php foreach($designers as $designer_id => $designer) {
							echo get_designer_list_view($designer_id, $designer);
						} ?>

						<?php endif; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left"><a href="<?php echo BASE_URL; ?>developer/list.php">Developers</a></h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php if (is_array($developers)) : ?>

						<?php foreach($developers as $developer_id => $developer) {
							echo get_developer_list_view($developer_id, $developer);
						} ?>

						<?php endif; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-1 module--no-pad">
					<header class="header--panel header--employer cf">
						<h3 class="float-left"><a href="<?php echo BASE_URL; ?>jobs/list.php">My Jobs</a></h3>
						<a href="<?php echo BASE_URL; ?>jobs/post.php"><button class="float-right button-action">Post Job</button></a>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php if (is_array($jobs)) : ?>

						<?php foreach($jobs as $job_id => $job) {
							echo get_job_list_view($job_id, $job);
						} ?>

						<?php endif; ?>
					</div>
				</article>
			</div>
		</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>