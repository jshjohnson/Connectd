<?php 
	require_once("../../config/config.php"); 
	require_once(ROOT_PATH . "inc/checklog.php");
	require_once(ROOT_PATH . 'inc/checklog.php');

	$pageTitle = "Employer";
	$section = "Employer";

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		$s_username = $_SESSION['username'];
	}

	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>	
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="float-left grid__cell module-1-3 module--no-pad user-sidebar--employer">
					<article class="user-sidebar module module--no-pad">
						<div class="user-sidebar__info">
							<div class="ribbon"><h5>New</h5></div>
							<h3 class="user-sidebar__title">Mixd</h3>
							<h4 class="user-sidebar__label icon--attach icon--marg">Digital Design Agency</h4>
							<h4 class="user-sidebar__label icon--location icon--marg">Harrogate, UK</h4>
							<h4 class="user-sidebar__label icon--globe icon--marg"><a href="">mixd.co.uk</a></h4>
							<p>
								We create beautifully-crafted websites that stand out from the crowd – and perfect function comes as standard.
							</p>
							<p>
								Our success is not only due to the quality of our work; it's down to attitude, our approach and the way we treat our clients.
							</p>
						</div>
					</article>
					<aside class="dashboard-panel module module--no-pad">
						<header class="header--panel header--employer cf">
							<h3 class="float-left">Worked with</h3>
						</header>
						<div class="module--half-pad">
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
						</div>
					</aside>
				</aside>
				<aside class="dashboard-panel grid__cell module-2-3 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Current jobs</h3>
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
								<button class="button-green button-small apply-trigger">
									<a href="">Apply</a>
								</button>
							</div>
						</div>
						<div class="media">
							<div class="media__desc media-2-3">
								<div class="media__button currency-button apply-trigger">
									<span class="currency">
										£14k
									</span>
								</div>
								<a href=""><p class="media__body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, nihil aliquam quod adipisci repellendus. Omnis corporis blanditiis unde ipsa eaque!</p></a>
							</div>
							<div class="media-1-3 media__side">
								<p><small>Posted 3rd July</small></p>
								<button class="button-green button-small apply-trigger">
									<a href="">Apply</a>
								</button>
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
								<button class="button-green button-small apply-trigger">
									<a href="">Apply</a>
								</button>
							</div>
						</div>
					</div>
				</aside>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for freelance work?
				</h4>
				<button class="button-green"><a href="<?php echo BASE_URL; ?>dashboard/">See our jobs list</a></button>
			</div>
		</section>
<?php include_once(ROOT_PATH . "views/footer-page.php"); ?>
