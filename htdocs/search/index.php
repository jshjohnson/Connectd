<?php 
	require_once("../config/config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle = "Search";
	$pageType = "Page";
	$section = "Blue";

	$general->loggedOutProtect();

	include_once(ROOT_PATH . "includes/header.inc.php"); ?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Search
						</blockquote>
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