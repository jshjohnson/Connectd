<?php 
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php"); 
	
	$general->loggedOutProtect();

	require_once(ROOT_PATH . "model/designers.php");

	// Grab ID from URL, convert to interger to strip SQL injection, pass to get_designers_single function to pull
	if (isset($_GET["id"])) {
		$designer_id = intval($_GET["id"]);
		$designer = get_designers_single($designer_id);
	}

	// If no ID in URL, return to dashboard;
	if (empty($designer)) {
		header("Location: " . BASE_URL);
		exit();
	}

	$pageTitle  = $designer['firstname'] . ' ' . $designer['lastname'] . ' :: ' . $designer['jobtitle'];
	$section    = "Designers";
		
	include_once(ROOT_PATH . "includes/header.inc.php");
?>
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-sidebar grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
					<div class="user-sidebar__price">
						<span class="currency">
							<h5>£<?= $designer['priceperhour']; ?></h5>
							<small>per hour</small>
						</span>
					</div>
					<div class="user-sidebar__header">
						<div class="user-sidebar__avatar">
							<img src="http://placehold.it/400x400" alt="">
						</div>
						<div class="button-wrapper">
							<a class="button-left btn btn--green cf hire-trigger" href="mailto:<?= $designer['email']; ?>?subject=I would like to hire you! -- Connectd&body=Hey <?= $designer['firstname']; ?>...">Hire <?= $designer['firstname']; ?></a>
							<a class="button-right btn btn--blue cf hire-trigger" href="mailto:<?= $designer['email']; ?>?subject=I would like to collaborate with you! -- Connectd&body=Hey <?= $designer['firstname']; ?>..."?>Collaborate</a>
						</div>
					</div>
					<div class="user-sidebar__info">
						<a href=""><i class="icon--star-alt"></i></a><h3 class="user-sidebar__title"><?= $designer['firstname'] . " " . $designer['lastname']; ?></h3>
						<h4 class="user-sidebar__label icon--attach icon--marg"><?= $designer['jobtitle']; ?></h4>
						<h4 class="user-sidebar__label icon--location icon--marg"><?= $designer['location']; ?></h4>
						<h4 class="user-sidebar__label icon--globe icon--marg"><a href="<?= $designer['portfolio']; ?>"><?php $url = preg_replace("(https?://)", "", $designer["portfolio"] ); echo $url ?></a></h4>
						<p><?= $designer['bio']; ?></p>
					</div>
				</aside>
				<article class="portfolio grid__cell module-2-3 module--no-pad float-left">
					<nav class="portfolio__headings-bg zero-bottom">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active active--blue"><a href="">Graphic Design</a></li>
							<li><a href="">Web Design</a></li>
							<li><a href="">App Design</a></li>
						</ul>
					</nav>
					<div class="container__inner">
						<ul class="grid grid__designer">
							<li class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/designer-1.png" alt="">
							</li>
							<li class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/designer-2.png" alt="">
							</li>
							<li class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/designer-3.jpg" alt="">
							</li>
							<li class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/designer-4.jpg" alt="">
							</li>
							<li class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/designer-5.jpg" alt="">
							</li>
							<li class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/designer-6.gif" alt="">
							</li>
						</ul>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active active--blue">Skills</li>
							<li class="float-right info"><a href="" class="des-skills-trigger">What are these skills?</a></li>
						</ul>
					</nav>
					<ul class="container__inner skills-wrapper">
						<li class="skills__tag">User Experience Design</li>
						<li class="skills__tag">Interface Design</li>
						<li class="skills__tag">Web Design</li>
						<li class="skills__tag">Graphical Design</li>
						<li class="skills__tag">Illustrator</li>
						<li class="skills__tag">Photoshop</li>
						<li class="skills__tag">InDesign</li>
					</ul>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active active--blue">Testimonial</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
					<blockquote>
						<p>“Josh's dedication, eye for detail, and professionalism was a great asset and incredibly appreciated. He showed creativity, ambition, and care, as evidenced both in the website he made and in instructing RASA's staff how to update and maintain the site. RASA highly commends Josh for his skills and effort."</p>
						<b class="source">Julia de Bresser, RASA Wakefield</b>
					</blockquote>
					</div>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for someone else?
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL; ?>designers/list/">See our talented bunch</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
