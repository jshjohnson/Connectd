<?php 	
	include_once("inc/header-developer.php");
	require_once('inc/checklog.php');
	include_once("inc/errors.php"); 
	include_once("inc/db_connect.php");
?>
		<header class="header cf">
			<div class="container">
				<h1 class="page-title">
					Dashboard<a href="logout.php" class="page-title__link"> : Log out</a>
				</h1>
				<h2 class="page-logo header-logo">
					<a href="index.php">connectd</a>
				</h2>
			</div>
		</header>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-left">
					<header class="header--panel header--designer cf">
						<h3 class="float-left">Designers</h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<div class="media">
						<?php	
							// create the SQL query
							$query = "SELECT firstname, lastname, jobtitle FROM connectdDB.designers";

							$result = mysqli_query($db_server, $query);

							if (!$result) die("Database access failed: " . mysqli_error($db_server));

							// if there are any rows, print out the contents
							while ($row = mysqli_fetch_array($result)) : ?>

							<a href=""><img src="assets/img/avatar-small-alt.jpg" alt="" class="media__img media__img--avatar"></a>
							<div class="media__body">
								<div class="float-left">
									<a href=""><i class="icon--star"></i></a><a href="designer.php"><h4><?php echo $row['firstname']. ' ' .$row['lastname']; ?></h4></a>
									<p><?php echo $row['jobtitle']; ?></p>
								</div>
								<div class="float-right price-per-hour">
									<h5>£36</h5>
									<span>per hour</span>
								</div>
							</div>

						<?php endwhile; ?>
							
						</div>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Developers</h3>
						<a href="" class="search-trigger"><h4 class="float-right icon--search"></h4></a>
					</header>
					<div class="media-wrapper">
						<?php	
							// create the SQL query
							$query = "SELECT firstname, lastname, jobtitle FROM connectdDB.developers";

							$result = mysqli_query($db_server, $query);

							if (!$result) die("Database access failed: " . mysqli_error($db_server));

							// if there are any rows, print out the contents
							while ($row = mysqli_fetch_array($result)) : ?>
						<div class="media">
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="media__img media__img--avatar"></a>
							<div class="media__body">
								<div class="float-left">
									<a href="developer.php"><h4><?php echo $row['firstname']. ' ' .$row['lastname']; ?></h4></a>
									<p><?php echo $row['jobtitle']; ?></p>
								</div>
								<div class="float-right price-per-hour">
									<h5>£24</h5>
									<span>per hour</span>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-1 module--no-pad">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">Recent Jobs</h3>
						<button class="float-right button-action post-job-trigger">Post Job</button>
					</header>
					<div class="media-wrapper media-wrapper--tall">
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button">
									<span class="currency">
										£1k
									</span>
								</div>
								<a href=""><p class="media__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, nihil aliquam quod adipisci repellendus. Omnis corporis blanditiis unde ipsa eaque!</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted 3rd July</small></p>
								<p><small>jshjohnson</small></p>
							</div>
						</div>
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button">
									<span class="currency">
										£3k
									</span>
								</div>
								<a href=""><p class="media__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, nihil aliquam quod adipisci repellendus. Omnis corporis blanditiis unde ipsa eaque!</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted 3rd July</small></p>
								<p><small>jshjohnson</small></p>
							</div>
						</div>
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button">
									<span class="currency">
										£14k
									</span>
								</div>
								<a href=""><p class="media__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, nihil aliquam quod adipisci repellendus. Omnis corporis blanditiis unde ipsa eaque!</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted 3rd July</small></p>
								<p><small>jshjohnson</small></p>
							</div>
						</div>
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button">
									<span class="currency">
										£300
									</span>
								</div>
								<a href=""><p class="media__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, nihil aliquam quod adipisci repellendus. Omnis corporis blanditiis unde ipsa eaque!</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted 3rd July</small></p>
								<p><small>jshjohnson</small></p>
							</div>
						</div>
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button">
									<span class="currency">
										£4k
									</span>
								</div>
								<a href=""><p class="media__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, nihil aliquam quod adipisci repellendus. Omnis corporis blanditiis unde ipsa eaque!</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted 3rd July</small></p>
								<p><small>jshjohnson</small></p>
							</div>
						</div>
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button">
									<span class="currency">
										£820
									</span>
								</div>
								<a href=""><p class="media__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, nihil aliquam quod adipisci repellendus. Omnis corporis blanditiis unde ipsa eaque!</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted 3rd July</small></p>
								<p><small>jshjohnson</small></p>
							</div>
						</div>
					</div>
				</article>
			</div>
		</section>

<?php 
require_once("inc/db_close.php"); //include file to do db connect
include_once("inc/footer-page.php"); 
?>
