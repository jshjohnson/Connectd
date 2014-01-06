<?php 	
	require_once("../inc/config.php"); 

	$pageTitle = "Search";
	include_once(ROOT_PATH . "inc/header.php");
	require_once(ROOT_PATH . "inc/checklog.php");
	include_once(ROOT_PATH . "inc/db_connect.php");
?>
		<header class="header cf">
			<div class="container">
				<h1 class="page-title">
					Search<a href="" class="menu-trigger page-title__link"> : Menu</a>
				</h1>
				<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
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
