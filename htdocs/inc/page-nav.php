				<?php if ($section == "Developer" || $section == "Dashboard") : ?>
				<nav class="header__nav header-navy--alt">
				<?php elseif ($section == "Designer" || $section == "Settings" || $section == "Sitemap") : ?>
				<nav class="header__nav header-blue--alt">
				<?php else: ?>
				<nav class="header__nav header-navy--alt">
				<?php endif; ?>
					<ul>
						<li><a href="<?= BASE_URL; ?>dashboard/">Dashboard</a></li>
						<li><a href="<?= BASE_URL; ?>trials/">Trials</a></li>
						<li><a href="<?= BASE_URL; ?>search/">Search</a></li>
						<li><a href="<?= BASE_URL . $userType . "s/" . $user_id . "/" ?>">View Profile</a></li>
						<li><a href="<?= BASE_URL . $userType . "s/" . $user_id . "/" ?>">Edit Profile</a></li>
						<li><a href="<?= BASE_URL; ?>settings/">Settings</a></li>
						<li><a href="<?= BASE_URL; ?>logout.php">Log out</a></li>
					</ul>
				</nav>