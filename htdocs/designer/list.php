<?php 
	require_once("../../config.php"); 
	include_once(ROOT_PATH . "inc/functions.php"); 

	checkLoggedOut();

	include_once(ROOT_PATH . "model/designers.php");

	$section = "Designers";
	$pageTitle = "Designers";

	$designers = get_designers_all();
	$designer_id = $_GET["id"];
	$designer = $designers[$designer_id];

	$s_username = $_SESSION['username'];

	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-sidebar grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
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
							echo get_designer_list_view($designer_id, $designer);
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
				<button class="button-red"><a href="<?php echo BASE_URL; ?>search/">Try refining your search</a></button>
			</div>
		</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>
