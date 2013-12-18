<?php
	require_once("../inc/config.php"); 
	require_once(ROOT_PATH . "inc/checklog.php");

	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/db_connect.php");

	// User data
	include_once(ROOT_PATH . "inc/designers.php");
	include_once(ROOT_PATH . "inc/developers.php");
	session_start();
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		$s_username = $_SESSION['username'];
	}
?>
		<header class="header cf">
			<div class="container">
				<h1 class="page-title">
					Dashboard<a href="" class="menu-trigger page-title__link"> : Menu</a>
				</h1>
				<nav class="header__nav">
					<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				</nav>
				<h2 class="page-logo header-logo">
					<a href="<?php echo BASE_URL; ?>dashboard/" class="icon--home">connectd</a>
				</h2>
			</div>
		</header>
		<section class="call-to-action call-to-action--top">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Welcome <?php echo $s_username; ?>
				</h4>
				<button class="button-red"><a href="<?php echo BASE_URL; ?>#">Build your profile</a></button>
			</div>
		</section>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-left">
					<header class="header--panel header--designer cf">
						<h3 class="float-left">Designers</h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php foreach($designers as $designer_id => $designer) : ?>
						<div class="media">
							<a href="<?php echo BASE_URL; ?>designer/profile.php?id=<?php echo $designer_id; ?>"><img src="<?php echo $designer['avatar']; ?>" alt="" class="media__img media__img--avatar"></a>
							<div class="media__body">
								<div class="float-left user-info">
									<a href=""><i class="icon--star"></i></a><a href="<?php echo BASE_URL; ?>designer/profile.php?id=<?php echo $designer_id; ?>"><h4><?php echo $designer['firstname'] . ' ' . $designer['lastname']; ?></h4></a>
									<p><?php echo $designer['jobtitle']; ?></p>
								</div>
								<div class="float-right price-per-hour">
									<h5>£36</h5>
									<span>per hour</span>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Developers</h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php foreach($developers as $developer_id => $developer) : ?>
						<div class="media">
							<a href="<?php echo BASE_URL; ?>developer/profile.php?id=<?php echo $developer_id; ?>"><img src="<?php echo $developer['avatar']; ?>" alt="" class="media__img media__img--avatar"></a>
							<div class="media__body">
								<div class="float-left user-info">
									<a href=""><i class="icon--star"></i></a><a href="<?php echo BASE_URL; ?>developer/profile.php?id=<?php echo $developer_id; ?>"><h4><?php echo $developer['firstname'] . ' ' . $developer['lastname']; ?></h4></a>
									<p><?php echo $developer['jobtitle']; ?></p>
								</div>
								<div class="float-right price-per-hour">
									<h5>£36</h5>
									<span>per hour</span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-1 module--no-pad">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">My Jobs</h3>
						<a href="<?php echo BASE_URL; ?>post/"><button class="float-right button-action">Post Job</button></a>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<?php	
							// create the SQL query
							$query = "SELECT jobtitle, budget, date FROM connectdDB.jobs ORDER BY date DESC";

							$result = mysqli_query($db_server, $query);

							if (!$result) die("Database access failed: " . mysqli_error($db_server));

							// if there are any rows, print out the contents
							while ($row = mysqli_fetch_array($result)) : ?>
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button">
									<span class="currency">
										<?php $budget = $row['budget']; 
										if ($budget>=10000) : ?>
											£<?php echo substr($budget, 0, 2); ?>k
										<?php elseif ($budget>=1000) : ?>
											£<?php echo substr($budget, 0, 1); ?>k
										<?php else : ?>
											£<?php echo $budget; ?>
										<?php endif; ?>

									</span>
								</div>
								<a href=""><p class="media__body"><?php echo $row['jobtitle']; ?></p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted <?php echo $row['date']; ?></small></p>
								<p><small>jshjohnson</small></p>
							</div>
						</div>
					<?php endwhile; ?>
					</div>
				</article>
			</div>
		</section>
<?php 
	require_once(ROOT_PATH . "inc/db_close.php");
	include_once(ROOT_PATH . "inc/footer-page.php"); 
?>
