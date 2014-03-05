<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");
	$general->loggedOutProtect();
	require_once(ROOT_PATH . "model/developers.php");

	if (isset($_GET["id"])) {
		$developer_id = $_GET["id"];
		$developer = get_developers_single($developer_id);
	}

	if (empty($developer)) {
		header("Location: " . BASE_URL);
		exit();
	}
	
	$pageTitle = $developer['firstname'] . ' ' . $developer['lastname'] . ' : ' . $developer['jobtitle'];
	$section = "Developer";

	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/page-header.php");

?>
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-sidebar grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-left">
					<div class="user-sidebar__price user-sidebar__price--alt">
						<span class="currency">
							<h5>£<?php echo $developer['priceperhour']; ?></h5>
							<small>per hour</small>
						</span>
					</div>
					<div class="user-sidebar__header">
						<div class="user-sidebar__avatar">
							<img src="http://placehold.it/400x400" alt="">
						</div>
						<div class="button-wrapper">
							<a class="button-left btn button-green cf hire-trigger" href="mailto:<?php echo $developer['email']; ?>?subject=I would like to hire you! -- Connectd&body=Hey <?php echo $developer['firstname']; ?>...">Hire <?php echo $developer['firstname']; ?></a>
							<a class="button-right btn button-blue cf hire-trigger" href="mailto:<?php echo $developer['email']; ?>?subject=I would like to collaborate with you! -- Connectd&body=Hey <?php echo $developer['firstname']; ?>..."?>Collaborate</a>
						</div>
					</div>
					<div class="user-sidebar__info">
						<h3 class="user-sidebar__title"><?php echo $developer['firstname'] . " " . $developer['lastname']; ?></h3>
						<h4 class="user-sidebar__label icon--attach icon--marg"><?php echo $developer['jobtitle']; ?></h4>
						<h4 class="user-sidebar__label icon--location icon--marg"><?php echo $developer['location']; ?></h4>
						<h4 class="user-sidebar__label icon--globe icon--marg"><a href="<?php echo $developer['portfolio']; ?>"><?php $url = preg_replace("(https?://)", "", $developer["portfolio"] ); echo $url ?></a></h4>
						<p><?php echo $developer['bio']; ?></p>
					</div>
				</aside>
				<article class="portfolio grid__cell module-2-3 module--no-pad float-right">
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings">
							<li class="active">Skills</li>
							<li class="float-right help"><a href="" class="dev-skills-trigger">What are these skills?</a></li>
						</ul>
					</nav>
					<div class="container__inner">
						<div class="grid--no-marg">
							<div class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="5">HTML5</div>
								</div>
							</div>
							<div class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="3">CSS3</div>
								</div>
							</div>
							<div class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="3">WordPress</div>
								</div>
							</div>
							<div class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="4">jQuery</div>
								</div>
							</div>
							<div class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="2">Git</div>
								</div>
							</div>
						</div>
					</div>
					<nav class="portfolio__headings-bg zero-bottom">
						<ul class="portfolio__headings portfolio__headings">
							<li class="active"><a href="">Responsive websites</a></li>
							<li><a href="">WordPress</a></li>
						</ul>
					</nav>
					<div class="container__inner">
						<div class="grid grid__developer">
							<div class="grid__cell grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/developer-1.jpg" alt="">
							</div>
							<div class="grid__cell grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/developer-2.jpg" alt="">
							</div>
							<div class="grid__cell grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/developer-3.png" alt="">
							</div>
							<div class="grid__cell grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/developer-4.jpg" alt="">
							</div>
						</div>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings">
							<li class="active">Testimonial</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
					<blockquote>
						"I have found Josh to be a very hard-working colleague. He is highly organised, has great communication skills and I have always been very impressed with the way that he has approached work. As such, we have been very happy to ask Josh to support our development team with on-going client work."
					</blockquote>
					<b>Phil Shackleton, Mixd</b>
					</div>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for someone else?
				</h4>
				<a class="btn button-red" href="<?= BASE_URL; ?>developers/list.php">See our talented bunch</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>