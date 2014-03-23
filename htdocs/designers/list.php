<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 

	$general->loggedOutProtect();

	$pageTitle       = "Designers";
	$section         = "Designers";

	$designers       = $designers->get_designers_all();
	$designer_id     = $_GET["id"];
	$designer        = $designers[$designer_id];

	include_once(ROOT_PATH . "includes/header.inc.php");
?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-module grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
					<header class="header--panel header--designer cf">
						<h3 class="float-left">Search</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
					</div>
				</aside>
				<article class="dashboard-panel grid__cell module-2-3 module--no-pad float-left">
					<header class="header--panel header--designer cf">
						<h3 class="float-left">Designers</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php foreach($designers as $designer_id => $designer) {
							include('../views/designer-list.view.html');
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
