<?php 	
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->logged_out_protect();

	$pageTitle = "Trials";
	$section = "Trials";

	$s_username = $_SESSION['username'];

	session_start();
	//Connect to DB
	require_once(ROOT_PATH . "core/connect/database.php");
	$db_server = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
	mysqli_select_db($db_server, DB_NAME) or die("Couldn't find db");

	$query = "SELECT firstname, lastname, jobtitle, location, portfolio, experience, time, votes FROM connectdDB.designers UNION SELECT firstname, lastname, jobtitle, location, portfolio, experience, time, votes FROM connectdDB.developers ORDER BY datejoined DESC";
	$result = mysqli_query($db_server, $query);

	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>
		<section class="container">
			<div class="grid cf">
			<?php while ($user = mysqli_fetch_array($result)) : ?>
				<aside class="grid__cell module-1-4 push-bottom">
					<article class="user-sidebar module--no-pad">
						<?php  if(strtotime($user["time"])>strtotime('-3 days')) : ?>
						     <div class="ribbon"><h5>New</h5></div>
						<?php endif ?>
						<div class="user-sidebar__info">
							<h3 class="user-sidebar__title user-sidebar__title--alt"><?php echo $user["firstname"] . "\n" . $user["lastname"]; ?></h3>
							<h4 class="user-sidebar__label icon--attach icon--marg"><?php echo $user["jobtitle"]; ?></h4>
							<h4 class="user-sidebar__label icon--location icon--marg"><?php echo $user["location"]; ?>, UK</h4>
							<h4 class="user-sidebar__label icon--briefcase icon--marg"><?php $url = preg_replace("(Between)", "", $user["experience"] ); echo $url ?> experience</h4>
							<h4 class="user-sidebar__label icon--globe icon--marg"><a href="<?php echo $user["portfolio"]; ?>"><?php $url = preg_replace("(https?://)", "", $user["portfolio"] ); echo $url ?></a></h4>
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
<?php include_once(ROOT_PATH . "views/footer.php"); ?>