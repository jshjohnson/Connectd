<?php 
	if ($section == "Designers" || $section == "Blue") {
		$navColor = "blue";
	} else if ($section == "Employers" || $section == "Job" || $section == "Green") {
		$navColor = "green";
	} else {
		$navColor = "navy";
	}
?>
				<a href="#nav" class="nav-toggle nav-toggle--open nav-toggle--divide icon--menu" id="nav-open-btn"></a>
				<nav id="nav" role="navigation" class="header__nav header-<?= $navColor; ?>--alt">
					<a href="#nav" class="nav-toggle nav-toggle--close icon--cancel" id="nav-close-btn"></a>
					<ul>
					<?php if ($users->loggedIn() === true) : ?>
						<li><a href="<?= BASE_URL; ?>dashboard/">Dashboard</a></li>
						<li><a href="<?= BASE_URL; ?>trials/">Trials</a></li>
						<li><a href="<?= BASE_URL . $sessionUserType . "/profile/" . $sessionUser['user_id'] . "/"?>">View Profile</a></li>
						<?php if($sessionUserType != "employer") : ?>
						<li><a href="<?= BASE_URL . "settings/edit-profile/"; ?>">Edit Profile</a></li>
						<?php endif; ?>
						<li><a href="<?= BASE_URL . "settings/account-settings/"; ?>">Account Settings</a></li>
						<li><a href="<?= BASE_URL . "settings/change-password/"; ?>">Change Password</a></li>
						<li><a href="<?= BASE_URL; ?>logout/">Log out</a></li>
					<?php else : ?>
						<li><a href="<?= BASE_URL; ?>">Home</a></li>
						<li><a href="<?= BASE_URL; ?>index.php#register">Register</a></li>
						<li><a href="<?= BASE_URL; ?>about/">About</a></li>
					<?php endif; ?>
					</ul>
				</nav>