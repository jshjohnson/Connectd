<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$general->loggedOutProtect();

	if (isset($_GET["id"])) {
		$developer_id = $_GET["id"];
		$developer = $developers->get_developers_single($developer_id);
	}

	if (empty($developer)) {
		header("Location: " . BASE_URL);
		exit();
	}
	
	$pageTitle  = $developer['firstname'] . ' ' . $developer['lastname'] . ' :: ' . $developer['jobtitle'];
	$section    = "Developers";

	include_once(ROOT_PATH . "includes/header.inc.php");

?>
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-module grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-left">
					<?php include('../views/developer-sidebar.view.php'); ?>
				</aside>
				<article class="portfolio grid__cell module-2-3 module--no-pad float-right">
					<?php include('../views/developer-portfolio.view.php'); ?>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for someone else?
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL; ?>developers/list/">See our talented bunch</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>