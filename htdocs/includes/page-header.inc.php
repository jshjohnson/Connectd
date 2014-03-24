	<header class="header cf 
		<?php if($section == "Designers") { ?>
			header--designer 
		<?php } else if($section == "Employers" || $section == "Jobs") { ?> 
			header--employer 
		<?php } ?>

		<?php if($pageType == "Page") { ?>
			zero-bottom
		<?php } ?>
		
		<?php if($pageType == "Page" && $section == "Blue") { ?>
			header-blue--alt
		<?php } else if($pageType == "Page" && $section == "Navy") { ?>
			header-navy--alt
		<?php } else if($pageType == "Page" && $section == "Green") { ?>
			header-green--alt
		<?php } ?>
		">
			<div class="container">
			<?php if (!isset($_SESSION['logged'])) : ?>
				<div class="header-section header-section--left">	
					<h1 class="header-section__title"><?= $pageTitle; ?>
						<?php if ($pageTitle == "Sign Up") : ?>
						<a href="" class="login-trigger header__section--title__link">: Log In</a>
						<!-- Revisit this -->
						<?php else : ?>
						<a href="<?= BASE_URL; ?>/#register" class="header__section--title__link">: Register</a>
						<?php endif;?>
					</h1>
					<?php include_once(ROOT_PATH . "includes/page-nav.inc.php"); ?>
				</div>

				<div class="header-section header-section--right">
					<h2 class="header-section__title header-section__title--username">
						<a href="<?= BASE_URL; ?>">connectd</a>
					</h2>
				</div>

			<?php else : ?>

				<div class="header-section header-section--left">
					<?php if($section == "Jobs" || $section == "Developers" || $section == "Designers" || $section == "Employers") : ?>	
					<h1 class="header-section__title"><?= $section; ?>
					<?php else : ?>
					<h1 class="header-section__title"><?= $pageTitle; ?>
					<?php endif; ?>
						<a href="" class="menu-trigger header-section__title--link">: Menu</a>
					</h1>
					<?php include_once(ROOT_PATH . "includes/page-nav.inc.php"); ?>
				</div>

				<div class="header-section header-section--right">
					<a href="<?= BASE_URL . "developers/" . $developer['user_id']; ?>/">
						<div style="background-image: url('<?= BASE_URL ?>assets/avatars/default_avatar.png');" class="header-section__avatar"></div>
					</a>
					<h2 class="header-section__title">
						<a href="<?= BASE_URL . "dashboard/" ?>" class="header-section__title--username"><?= $username; ?></a>
					</h2>
				</div>

			<?php endif; ?>
			</div>
		</header>