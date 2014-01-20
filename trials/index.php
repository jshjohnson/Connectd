<?php 	
	require_once("../config/config.php");
	include_once(ROOT_PATH . "inc/functions.php");
	checkLoggedOut();

	$pageTitle = "Trials";
	$section = "Trials";

	$s_username = $_SESSION['username'];

	session_start();
	//Connect to DB
	require_once(ROOT_PATH . "inc/db_connect.php");
	$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
	mysqli_select_db($db_server, $db_database) or die("Couldn't find db");

	$query = "SELECT firstname, lastname, jobtitle, location, portfolio, datejoined, votes FROM connectdDB.designers UNION SELECT firstname, lastname, jobtitle, location, portfolio, datejoined, votes FROM connectdDB.developers ORDER BY datejoined DESC";
	$result = mysqli_query($db_server, $query);

	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>
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
							<div class="text-center">
								<button class="button-green button-small">
									<a href="" class="icon--check"><?php echo $user["votes"]; ?> votes</a>
								</button>
							</div>
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
	include_once(ROOT_PATH . "views/footer-page.php"); 
?>