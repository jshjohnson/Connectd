<?php 	
	include_once("inc/functions.php");
	session_start();
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard.php');
	}
?>
<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js home" lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>connectd</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!--[if lte IE 8]>
	    <link rel="stylesheet" href="assets/css/ie.css" media="screen">
	    
	    <script src="assets/js/libs/selectivizr-min.js"></script>
	<![endif]-->
	<!--[if gt IE 8]><!-->
	    <link rel="stylesheet" href="assets/css/screen.css">
	<!--<![endif]-->	
	<script src="assets/js/libs/modernizr-2.5.3.min.js"></script>
	<script type="text/javascript" src="//use.typekit.net/dxr1afv.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body>
	<h2 class="logo text-right"><a href="index.php">connectd</a></h2>
	<h2 class="text-left"><a href="" class="login-trigger">Sign in</a></h2>
	<div class="panel-wrap">
		<section class="panel panel--designer panel-1-3">
			<div class="panel__container">
				<h1 class="panel__title">
					<a href="signup-design.php"><span>I'm a</span> Designer</a>
				</h1>
			</div>
		</section>
		<section class="panel panel--developer panel-1-3">
			<div class="panel__container">
				<h1 class="panel__title">
					<a href="signup-develop.php"><span>I'm a</span> Developer</a>
				</h1>
			</div>
		</section>
		<section class="panel panel--employer panel-1-3 float-right">
			<div class="panel__container">
				<h1 class="panel__title">
					<a href="signup-employ.php"><span>I'm an</span> Employer</a>
				</h1>
			</div>
		</section>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="assets/js/libs/jquery-1.7.2.min.js"><\/script>')</script>
	<script src="assets/js/scripts.min.js"></script>
</body>
</html>
