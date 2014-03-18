<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle = "Sitemap";
	$section = "Sitemap";

	$general->loggedOutProtect();

	include_once(ROOT_PATH . "includes/header.inc.php"); ?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Sitemap
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
				<ul class="zero-bottom">
					<li><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li>
					<li><a href="dashboard.php">Dashboard</a></li>
					<li><a href="designer.php">Designer</a></li>
					<li><a href="developer.php">Developer</a></li>
					<li><a href="employer.php">Employer</a></li>
					<li><a href="sitemap.php">Sitemap</a></li>
					<li><a href="terms.php">Terms</a></li>
				</ul>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>