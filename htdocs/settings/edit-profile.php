<?php 	
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle = "Settings";
	$section = "Settings";
	
	$general->logged_out_protect();
	
	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/page-header.php");
?>  
		<section class="container footer--push">
			<div class="grid--no-marg cf">
			</div>
		</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>
