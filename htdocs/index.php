<?php 	
	require_once("config.php");
	require_once(ROOT_PATH . "core/init.php");
	
	$general->errors();
	// $general->loggedOutProtect();

	if (isset($_GET['p'])) {
		$p = $_GET['p'];
	}else {
		$p = NULL;
	}

	switch ($p) {
		case "about":
			$page = "page/about.html";
			$pageTitle = "About";
			$pageType = "Page";
			$section = "Blue";
			break;
		case "terms":
			$page = "page/terms.html";
			$pageTitle = "Terms & Conditions";
			$pageType = "Page";
			$section = "Blue";
			break;
		case "sitemap":
			$page = "page/sitemap.html";
			$pageTitle = "Sitemap";
			$pageType = "Page";
			$section = "Blue";
			break;
		case "search":
			$page = "search/search.html";
			$pageTitle = "Search";
			$pageType = "Page";
			$section = "Blue";
			$general->loggedOutProtect();
			break;
		case "404":
			$page = "error/404.html";
			$pageTitle = "404";
			$pageType = "Page";
			$section = "Blue";
			break;
		default:
			$page = "index/index.html";
			$pageTitle = "Connectd";
			$pageType = "Home";
			$section = "Home";
			$general->loggedInProtect();
			break;
	}

	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/" . $page);
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>  
