<?php 	
	require_once("../inc/config.php"); 
	include_once(ROOT_PATH . "inc/header-page.php");
	require_once(ROOT_PATH . "inc/checklog.php");
	include_once(ROOT_PATH . "inc/errors.php"); 
	include_once(ROOT_PATH . "inc/db_connect.php");
?>
		<header class="header cf">
			<div class="container">
				<h1 class="page-title">
					Search<a href="" class="menu-trigger page-title__link"> : Menu</a>
				</h1>
				<nav class="header__nav">
					<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				</nav>
				<h2 class="page-logo header-logo">
					<a href="<?php echo BASE_URL; ?>dashboard/" class="icon--home">connectd</a>
				</h2>
			</div>
		</header>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				
			</div>
		</section>
<?php 
	require_once(ROOT_PATH . "inc/db_close.php");
	include_once(ROOT_PATH . "inc/footer-page.php"); 
?>
