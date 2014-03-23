<?php 	
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");
	
	$general->errors();
	$general->loggedInProtect();

	$pageTitle         = "Connectd";
	$pageType          = "Home";
	$section           = "Home";

	include_once(ROOT_PATH . "includes/header.inc.php");
?>
		<header class="site-intro">
			<div class="site-intro__wrap">
<!-- 				<a href="#register"><h1 class="site-intro__heading">connectd.io</h1></a> -->
				<a href="#register"><img src="<?= BASE_URL ?>assets/img/logo-test.svg" alt="" class="site-intro__logo"></a>
				<a href="#register"><h1 class="site-intro__sub-heading">An alternative for freelancers and employers</h1></a>
				<a href="<?= BASE_URL; ?>about/" class="site-intro__link">Find out more</a>
			</div>
		</header>
		<h2 class="homepage__text-right"><a href="<?= BASE_URL; ?>">connectd</a></h2>

		<?php if (isset($_SESSION['logged'])) : ?>
		<h2 class="homepage__text-left"><a href="<?= BASE_URL ?>logout.php">Logout</a></h2>
		<?php else : ?>
		<h2 class="homepage__text-left"><a href="" class="login-trigger">Login</a></h2>
		<?php endif; ?>
		<div id="register" class="panel-wrap">
			<section class="panel panel--designer panel-1-3">
				<div class="panel__container">
					<h1 class="panel__title">
						<a href="<?= BASE_URL; ?>designers/"><span>I'm a</span> Designer</a>
					</h1>
				</div>
			</section>
			<section class="panel panel--developer panel-1-3">
				<div class="panel__container">
					<h1 class="panel__title">
						<a href="<?= BASE_URL; ?>developers/"><span>I'm a</span> Developer</a>
					</h1>
				</div>
			</section>
			<section class="panel panel--employer panel-1-3 float-right">
				<div class="panel__container">
					<h1 class="panel__title">
						<a href="<?= BASE_URL; ?>employers/"><span>I'm an</span> Employer</a>
					</h1>
				</div>
			</section>
		</div>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>