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
					Settings<a href="" class="menu-trigger page-title__link"> : Menu</a>
				</h1>
				<nav class="header__nav">
					<ul>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li><a href="">Search</a></li>
						<li><a href="">View Profile</a></li>
						<li><a href="">Edit Profile</a></li>
						<li><a href="settings.php">Settings</a></li>
						<li><a href="logout.php">Log out</a></li>
					</ul>
				</nav>
				<h2 class="page-logo header-logo">
					<a href="index.php" class="icon--home">connectd</a>
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
