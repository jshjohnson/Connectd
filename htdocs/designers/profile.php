<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 
	
	$general->loggedOutProtect();

	// Grab ID from URL, convert to interger to strip SQL injection, pass to get_designers_single function to pull
	if (isset($_GET["id"])) {
		$designer_id = intval($_GET["id"]);
		$designer = $designers->get_designers_single($designer_id);
	}

	// If no ID in URL, return to dashboard;
	if (empty($designer)) {
		header("Location: " . BASE_URL);
		exit();
	}

	$pageTitle  = $designer['firstname'] . ' ' . $designer['lastname'] . ' :: ' . $designer['jobtitle'];
	$section    = "Designers";
		
	include_once(ROOT_PATH . "includes/header.inc.php");
?>
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-module grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
					<?php include('../views/designer_sidebar_view.php'); ?>
				</aside>
				<article class="portfolio grid__cell module-2-3 module--no-pad float-left">
					<?php include('../views/designer_portfolio_view.php'); ?>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for someone else?
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL; ?>designers/list/">See our talented bunch</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
