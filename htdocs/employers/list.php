<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 

	$general->loggedOutProtect();

	$pageTitle       = "Employers";
	$section         = "Employers";

	$employers       = $employers->get_employers_all();
	$employer_id     = $_GET["id"];
	$employer        = $employers[$employer_id];

	include_once(ROOT_PATH . "includes/header.inc.php");
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
						<h3 class="float-left">Employers</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php foreach($employers as $employer_id => $employer) {
							include('../views/employer-list.html');
						} ?>
					</div>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Can't find the right designer?
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL; ?>search/">Try refining your search</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
