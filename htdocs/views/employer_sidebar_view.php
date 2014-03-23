					<article class="user-module module module--no-pad">
						<div class="user-module__info">
							<?php  if(strtotime(date('F j, Y', $employer['time_joined']))>strtotime('-3 days')) : ?>
							     <div class="ribbon"><h5>New</h5></div>
							<?php endif ?>
							<?php 
								$employerName = $employer['employer_name'];

								if (strlen($employerName)>=23) {
									echo "<h3 class=\"user-module__title user-module__title--alt\">" . $employerName . "</h3>";
								} else {
									echo "<h3 class=\"user-module__title\">" . $employerName . "</h3>";
								}
							?>
							<h4 class="user-module__label icon--attach icon--marg"><?= $employer['employer_type']; ?></h4>
							<h4 class="user-module__label icon--location icon--marg"><?= $employer['location']; ?></h4>
							<h4 class="user-module__label icon--globe icon--marg"><a href="<?= $employer['portfolio']; ?>"><?= $employer['portfolio']; ?></a></h4>
							<p><?= $employer['bio']; ?></p>
						</div>
					</article>
					<article class="dashboard-panel module module--no-pad">
						<header class="header--panel header--employer cf">
							<h3 class="float-left">Worked with</h3>
						</header>
						<div class="module--half-pad">
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
							<a href=""><img src="<?= BASE_URL; ?>assets/img/avatar-small.jpg" alt="" class="module__avatar img--avatar"></a>
						</div>
					</article>