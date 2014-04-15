				<a href="#nav" class="nav-toggle nav-toggle--open icon--menu" id="nav-open-btn"></a>
				<?php if ($section == "Developers" || $section == "Navy") : ?>
				<nav id="nav" role="navigation" class="header__nav header-navy--alt">
				<?php elseif ($section == "Designers" || $section == "Blue") : ?>
				<nav id="nav" role="navigation" class="header__nav header-blue--alt">
				<?php elseif ($section == "Employers" || $section == "Jobs" || $section == "Green") : ?>
				<nav id="nav" role="navigation" class="header__nav header-green--alt">
				<?php else : ?>
				<nav id="nav" role="navigation" class="header__nav header-navy--alt">
				<?php endif; ?>
					<a href="#nav" class="nav-toggle nav-toggle--close icon--cancel" id="nav-close-btn"></a>
					<ul>
					<?php if ($users->loggedIn() === true) : ?>
						<li><a href="<?= BASE_URL; ?>dashboard/">Dashboard</a></li>
						<li><a href="<?= BASE_URL; ?>trials/">Trials</a></li>
						<li><a href="<?= BASE_URL; ?>search">Search</a></li>
						<li><a href="<?= BASE_URL . "profile.php?usertype=" . $sessionUserType . "&id=" . $sessionUser['user_id'];?>">View Profile</a></li>
						<li><a href="<?= BASE_URL . "edit-profile"?>">Edit Profile</a></li>
						<li><a href="<?= BASE_URL . "change-password"; ?>">Change Password</a></li>
						<li><a href="<?= BASE_URL; ?>logout.php">Log out</a></li>
					<?php else : ?>
						<li><a href="<?= BASE_URL; ?>">Home</a></li>
						<li><a href="<?= BASE_URL; ?>index.php#register">Register</a></li>
						<li><a href="<?= BASE_URL; ?>about/">About</a></li>
					<?php endif; ?>
					</ul>
				</nav>