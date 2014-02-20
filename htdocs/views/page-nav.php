				<?php if ($section == "Developer" || $section == "Dashboard") : ?>
				<nav class="header__nav header-navy--alt">
				<?php elseif ($section == "Designer") : ?>
				<nav class="header__nav header-blue--alt">
				<?php elseif ($section == "Employer") : ?>
				<nav class="header__nav header-green--alt">
				<?php else: ?>
				<nav class="header__nav header-navy--alt">
				<?php endif; ?>
					<ul>
						<li><a href="<?php echo BASE_URL; ?>dashboard/">Dashboard</a></li>
						<li><a href="<?php echo BASE_URL; ?>trials/">Trials</a></li>
						<li><a href="<?php echo BASE_URL; ?>search/">Search</a></li>
						<li><a href="<?php echo BASE_URL . "developer/profile.php?id=" . $_SESSION['userID']; ?>">View Profile</a></li>
						<li><a href="<?php echo BASE_URL . "developer/profile.php?id=" . $_SESSION['userID']; ?>?>">Edit Profile</a></li>
						<li><a href="<?php echo BASE_URL; ?>settings/">Settings</a></li>
						<li><a href="<?php echo BASE_URL; ?>logout.php">Log out</a></li>
					</ul>
				</nav>