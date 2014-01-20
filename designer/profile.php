<?php 
	require_once("../config/config.php"); 	
	require_once(ROOT_PATH . "inc/checklog.php");
	include_once(ROOT_PATH . "views/designers.php");

	$designers = get_designers_all();
	$designer_id = $_GET["id"];
	$designer = $designers[$designer_id];

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		$s_username = $_SESSION['username'];
	}

	$pageTitle = $designer['firstname'] . ' ' . $designer['lastname'];
	$section = "Designer";
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/header-logged.php");
?>		
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-sidebar grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-right">
					<div class="user-sidebar__price">
						<span class="currency">
							<h5>£26</h5>
							<small>per hour</small>
						</span>
					</div>
					<div class="user-sidebar__header">
						<div class="user-sidebar__avatar">
							<img src="<?php echo $designer['avatar']; ?>" alt="">
						</div>
						<div class="button-wrapper">
							<button class="button-green button-left cf hire-trigger">
								<a href="">Hire Me</a>
							</button>
							<button class="button-blue button-right cf collaborate-trigger">
								<a href="">Collaborate</a>
							</button>
						</div>
					</div>
					<div class="user-sidebar__info">
						<a href=""><i class="icon--star-alt"></i></a><h3 class="user-sidebar__title"><?php echo $pageTitle; ?></h3>
						<h4 class="user-sidebar__job icon--attach icon--marg"><?php echo $designer['jobtitle']; ?></h4>
						<h4 class="user-sidebar__geo icon--location icon--marg"><?php echo $designer['location']; ?></h4>
						<h4 class="user-sidebar__web icon--globe icon--marg"><a href="<?php echo $designer['portfolio']; ?>" target="_blank"><?php $url = preg_replace("(https?://)", "", $designer["portfolio"] ); echo $url ?></a></h4>
						<p>
							<?php echo $designer['bio']; ?>
						</p>
					</div>
				</aside>
				<article class="portfolio grid__cell module-2-3 module--no-pad float-left">
					<nav class="portfolio__headings-bg zero-bottom">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active"><a href="">Graphic Design</a></li>
							<li><a href="">Web Design</a></li>
							<li><a href="">App Design</a></li>
						</ul>
					</nav>
					<div class="container__inner">
						<div class="grid grid__designer">
							<div class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/designer-1.png" alt="">
							</div>
							<div class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/designer-2.png" alt="">
							</div>
							<div class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/designer-3.jpg" alt="">
							</div>
							<div class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/designer-4.jpg" alt="">
							</div>
							<div class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/designer-5.jpg" alt="">
							</div>
							<div class="grid__cell unit-1-3--bp3 unit-1-2--bp2 unit-1-2--bp1 grid__cell--img">
								<img src="<?php echo BASE_URL; ?>assets/img/designer-6.gif" alt="">
							</div>
						</div>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active">Skills</li>
							<li class="float-right help"><a href="" class="des-skills-trigger">What are these skills?</a></li>
						</ul>
					</nav>
					<div class="container__inner skills-wrapper">
						<div class="skills__tag">User Experience Design</div>
						<div class="skills__tag">Interface Design</div>
						<div class="skills__tag">Web Design</div>
						<div class="skills__tag">Graphical Design</div>
						<div class="skills__tag">Illustrator</div>
						<div class="skills__tag">Photoshop</div>
						<div class="skills__tag">InDesign</div>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings--alt">
							<li class="active">Testimonial</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
					<blockquote>
						“Josh's dedication, eye for detail, and professionalism was a great asset and incredibly appreciated. He showed creativity, ambition, and care, as evidenced both in the website he made and in instructing RASA's staff how to update and maintain the site. RASA highly commends Josh for his skills and effort."
					</blockquote>
					<b>Julia de Bresser, RASA Wakefield</b>
					</div>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for someone else?
				</h4>
				<button class="button-red"><a href="<?php echo BASE_URL; ?>search/">See our talented bunch</a></button>
			</div>
		</section>
<?php include_once(ROOT_PATH . "views/footer-page.php"); ?>
