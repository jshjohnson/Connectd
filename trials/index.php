<?php 	
	require_once("../inc/config.php"); 
	include_once(ROOT_PATH . "inc/header.php");
	require_once(ROOT_PATH . "inc/checklog.php");

	session_start();
	//Connect to DB
	require_once(ROOT_PATH . "inc/db_connect.php");

	mysqli_select_db($db_server, $db_database) or die("Couldn't find db");

	$query = "SELECT firstname, lastname, jobtitle, location, portfolio, datejoined FROM connectdDB.designers UNION SELECT firstname, lastname, jobtitle, location, portfolio, datejoined FROM connectdDB.developers ORDER BY datejoined DESC";
	$result = mysqli_query($db_server, $query);

?>
		<header class="header cf">
			<div class="container">
				<h1 class="page-title">
					Trials<a href="" class="menu-trigger page-title__link"> : Menu</a>
				</h1>
				<nav class="header__nav">
					<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				</nav>
				<h2 class="page-logo header-logo">
					<a href="index.php">connectd</a>
				</h2>
			</div>
		</header>
		<section class="container">
			<div class="grid cf">
			<?php while ($user = mysqli_fetch_array($result)) : ?>
				<aside class="grid__cell module-1-4 push-bottom">
					<article class="user-sidebar module--no-pad">
						<?php  if(strtotime($user["datejoined"])>strtotime('-3 days')) : ?>
						     <div class="ribbon"><h5>New</h5></div>
						<?php endif ?>
						<div class="user-sidebar__info">
							<h3 class="user-sidebar__title user-sidebar__title--alt"><?php echo $user["firstname"] . "\n" . $user["lastname"]; ?></h3>
							<h4 class="user-sidebar__job icon--attach icon--marg"><?php echo $user["jobtitle"]; ?></h4>
							<h4 class="user-sidebar__geo icon--location icon--marg"><?php echo $user["location"]; ?>, UK</h4>
							<h4 class="user-sidebar__web icon--globe icon--marg"><a href="<?php echo $user["portfolio"]; ?>" target="_blank"><?php $url = preg_replace("(https?://)", "", $user["portfolio"] ); echo $url ?></a></h4>
						</div>
					</article>
				</aside>
			<?php endwhile; ?>
			</div>
		</section>
		<section class="call-to-action footer-push">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for freelance work?
				</h4>
				<button class="button-green"><a href="dashboard.html">See our jobs list</a></button>
			</div>
		</section>
<?php 
	require_once(ROOT_PATH . "inc/db_close.php");
	include_once(ROOT_PATH . "inc/footer-page.php"); 
?>