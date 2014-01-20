<?php 	
	require_once("../inc/config.php"); 
	require_once(ROOT_PATH . "inc/checklog.php");
	include_once(ROOT_PATH . "inc/db_connect.php");

	$pageTitle = "Search";
	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/header-logged.php");
?>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				
			</div>
		</section>
<?php 
	require_once(ROOT_PATH . "inc/db_close.php");
	include_once(ROOT_PATH . "inc/footer-page.php"); 
?>
