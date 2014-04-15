<?php ob_start();
	if(isset($pageType)) {
		$isHome = $pageType == "Home" || $section == "Welcome";
	}
	
?>
<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js <?php if($isHome) : ?>home<?php endif; ?>" lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?= $pageTitle; ?> <?php if(!$isHome) : ?>:: Connectd<?php endif; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!--[if lte IE 8]>
	    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/ie.css" media="screen">
	    
	    <script src="<?= BASE_URL; ?>assets/js/libs/selectivizr-min.js"></script>
	<![endif]-->
	<!--[if gt IE 8]><!-->
	    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/global.css">
	<!--<![endif]-->
	<script src="<?= BASE_URL; ?>assets/js/libs/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="//use.typekit.net/dxr1afv.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	<script>var baseUrl = '<?= BASE_URL; ?>';</script>
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49432332-1', 'connectd.io');
  ga('send', 'pageview');

</script>
	<?php if(!$isHome) : ?>
	<div class="outer">
		<div id="inner-wrap" class="site site-wrap <?php if($pageType == "Page") : ?>site-wrap--page<?php endif;?>">
		<?php include_once(ROOT_PATH . "includes/page-header.inc.php"); ?>
	<?php else :?>
	<div class="site site-wrap--home">
	<?php endif;?>