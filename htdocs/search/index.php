<?php 	
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");
	$general->logged_out_protect();

	$pageTitle = "Search";
	$section = "Search";
	
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				
			</div>
		</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>
