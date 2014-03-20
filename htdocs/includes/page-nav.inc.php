				<?php if ($section == "Developers" || $section == "Dashboard") : ?>
				<nav class="header__nav header-navy--alt">
				<?php elseif ($section == "Designers" || $section == "Settings" || $section == "Sitemap" || $section == "About") : ?>
				<nav class="header__nav header-blue--alt">
				<?php elseif ($section == "Employers") : ?>
				<nav class="header__nav header-green--alt">
				<?php else : ?>
				<nav class="header__nav header-navy--alt">
				<?php endif; ?>
					<ul>
					<?php if ($general->loggedIn() === true) : ?>
						<li><a href="<?= BASE_URL; ?>dashboard/">Dashboard</a></li>
						<li><a href="<?= BASE_URL; ?>trials/">Trials</a></li>
						<li><a href="<?= BASE_URL; ?>search/">Search</a></li>
						<li><a href="<?= BASE_URL . $userType . "s/" . $user_id . "/" ?>">View Profile</a></li>
						<li><a href="<?= BASE_URL . "edit-profile/" . $user_id . "/" ?>">Edit Profile</a></li>
						<li><a href="<?= BASE_URL . "account-settings/" . $user_id . "/" ?>">Account Settings</a></li>
						<li><a href="<?= BASE_URL; ?>logout.php">Log out</a></li>
					<?php else : ?>
						<li><a href="<?= BASE_URL; ?>">Home</a></li>
						<li><a href="<?= BASE_URL; ?>index.php#register">Register</a></li>
						<li><a href="<?= BASE_URL; ?>about/">About</a></li>
					<?php endif; ?>
					</ul>
				</nav>
