<?php 	
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");
	
	$general->errors();
	$general->loggedInProtect();

	include_once(ROOT_PATH . "inc/header-home.php");
?>
		<header class="site-intro">
			<div class="site-intro__wrap">
				<a href="#register"><h1 class="site-intro__heading">connectd.io</h1></a>
				<a href="#register"><h1 class="site-intro__sub-heading">An alternative for freelancers and employers</h1></a>
				<a href="" class="site-intro__link">Find out more</a>
			</div>
		</header>
		<h2 class="logo text-right"><a href="<?php echo BASE_URL; ?>">connectd</a></h2>
		<h2 class="text-left"><a href="" class="login-trigger">Login</a></h2>
		<div id="register" class="panel-wrap">
			<section class="panel panel--designer panel-1-3">
				<div class="panel__container">
					<h1 class="panel__title">
						<a href="<?php echo BASE_URL; ?>designers/"><span>I'm a</span> Designer</a>
					</h1>
				</div>
			</section>
			<section class="panel panel--developer panel-1-3">
				<div class="panel__container">
					<h1 class="panel__title">
						<a href="<?php echo BASE_URL; ?>developers/"><span>I'm a</span> Developer</a>
					</h1>
				</div>
			</section>
			<section class="panel panel--employer panel-1-3 float-right">
				<div class="panel__container">
					<h1 class="panel__title">
						<a href="<?php echo BASE_URL; ?>employers/"><span>I'm an</span> Employer</a>
					</h1>
				</div>
			</section>
		</div>
<?php include_once(ROOT_PATH . "inc/footer-home.php"); ?>