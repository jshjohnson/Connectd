<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle = "Sitemap";
	$section = "Sitemap";

	$general->logged_out_protect();

	include_once(ROOT_PATH . "inc/header.php"); ?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
				<?php if (!isset($_SESSION['logged'])) :?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="login-trigger header__section--title__link">: Log In</a>
				</h1>
				<?php else : ?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="menu-trigger header__section--title__link">: Menu</a>
				</h1>
					<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				<?php endif; ?>
			<h2 class="header__section header__section--logo">
				<a href="<?= BASE_URL ?>">connectd</a>
			</h2>
		</div>
	</header>
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
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">
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
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>