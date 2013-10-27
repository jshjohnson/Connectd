<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Sign Up : connectd</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!--[if lte IE 8]>
	    <link rel="stylesheet" href="assets/css/ie.css" media="screen">
	    <link rel="stylesheet" href="assets/css/print.css" media="print">
	    <script src="assets/js/libs/selectivizr-min.js"></script>
	<![endif]-->
	<!--[if gt IE 8]><!-->
	    <link rel="stylesheet" href="assets/css/screen.css">
	<!--<![endif]-->
	<link rel="stylesheet" href="assets/css/print.css" media="print">
	<script src="assets/js/libs/modernizr-2.5.3.min.js"></script>
	<script type="text/javascript" src="//use.typekit.net/dxr1afv.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body class="site">
	<header class="header header--alt zero-bottom cf">
		<div class="container">
			<h1 class="page-title">
				Sign Up
			</h1>
			<h2 class="page-logo header-logo">
				<a href="index.php">connectd</a>
			</h2>
		</div>
	</header>
	<section>
		<div class="section-form color-blue">
			<div class="grid text-center">
				<div class="grid__cell unit-1-2--bp4">
					<blockquote class="intro-quote">
						The beginning of something special...
					</blockquote>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp4 form-overlay">
				<form method="post" action="register.php">
					<input type="text" name="firstname" required placeholder="First name">
					<input type="text" name="firstname" required placeholder="Surname">
					<input type="email" name="email" required placeholder="Email">
					<input type='password' id='password' name='password' required placeholder="Password">
					<input type='password' id='password' name='repeatpassword' required placeholder="Repeat Password">
					<input type="text" name="job" required placeholder="Job Title">
					<input type="number" name="age" required placeholder="Age">
					<input type="number" name="experience" required placeholder="Years Experience">
					<textarea name="about" id="" cols="30" rows="10" placeholder="A little about you..."></textarea>
		            <input class="submit" type="submit" value="Apply for your place">
		            <small>By clicking on "Sign Up" below, you agree to the <a href="">Terms &amp; Conditions.</a></small>
		        </form>
			</div>
		</div>
	</section>
	<footer class="footer zero-top cf">
		<div class="container">
			<div class="grid">
				<ul class="grid__cell unit-1-2--bp2 footer__links">
					<li><a href="about.html">About</a></li>
					<li><a href="">Terms &amp; Conditions</a></li>
				</ul>
				<h2 class="grid__cell unit-1-2--bp2 page-logo footer__logo">
					<a href="index.php">connectd</a>
				</h2>
			</div>
		</div>
	</footer>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="assets/js/libs/jquery-1.7.2.min.js"><\/script>')</script>
	<script src="assets/js/scripts.min.js"></script>
</body>
</html>