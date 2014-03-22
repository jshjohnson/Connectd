<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 

	$general->loggedOutProtect();

	$section         = "Developers";
	$pageTitle       = "Developers";

	$developers      = $developers->get_developers_all();
	$developer_id    = $_GET["id"];
	$developer       = $developers[$developer_id];

	include_once(ROOT_PATH . "includes/header.inc.php");
?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-sidebar grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Search</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
					</div>
				</aside>
				<article class="dashboard-panel grid__cell module-2-3 module--no-pad float-left">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Developers</h3>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php foreach($developers as $developer_id => $developer) {
							include('../views/developer_list_view.php');
						} ?>
					</div>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Can't find the right developer?
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL; ?>search/">Try refining your search</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
