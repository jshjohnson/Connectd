		<?php if($section == "Employer") : ?>
		<header class="header header--employer cf">
		<?php elseif($section == "Designer") : ?>
		<header class="header header--designer cf">
		<?php else : ?>
		<header class="header cf">
		<?php endif ?>
			<div class="container">
				<h1 class="header__section header__section--title">
					<?php echo $pageTitle; ?><a href="" class="menu-trigger header__section--title__link "> : Menu</a>
				</h1>
				<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				<h2 class="header__section header__section--username">
					<a href="<?php echo BASE_URL; ?>dashboard/" class="header-username"><?php echo $s_username; ?></a>
				</h2>
				<h2 class="header__section header__section--notifications">
					<a href="#">3</a>
				</h2>
			</div>
		</header>