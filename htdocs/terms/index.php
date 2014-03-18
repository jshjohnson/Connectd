<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle = "Terms & Conditions";
	$section = "Page";

	$general->loggedOutProtect();

	include_once(ROOT_PATH . "includes/header.inc.php"); ?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>