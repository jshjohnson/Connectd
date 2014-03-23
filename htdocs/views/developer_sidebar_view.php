					<div class="badge badge--right color-red">
						<span class="badge__inner">
							<h5>£<?= $developer['priceperhour']; ?></h5>
							<small>per hour</small>
						</span>
					</div>
					<div class="user-module__header">
						<div class="user-module__avatar">
							<img src="http://placehold.it/400x400" alt="">
						</div>
						<div class="button-wrapper">
							<a class="button--left btn btn--green cf hire-trigger" href="mailto:<?= $developer['email']; ?>?subject=I would like to hire you! -- Connectd&body=Hey <?= $developer['firstname']; ?>...">Hire <?= $developer['firstname']; ?></a>
							<a class="button--right btn btn--blue cf hire-trigger" href="mailto:<?= $developer['email']; ?>?subject=I would like to collaborate with you! -- Connectd&body=Hey <?= $developer['firstname']; ?>..."?>Collaborate</a>
						</div>
					</div>
					<div class="user-module__info">
						<h3 class="user-module__title"><?= $developer['firstname'] . " " . $developer['lastname']; ?></h3>
						<h4 class="user-module__label icon--attach icon--marg"><?= $developer['jobtitle']; ?></h4>
						<h4 class="user-module__label icon--location icon--marg"><?= $developer['location']; ?></h4>
						<h4 class="user-module__label icon--globe icon--marg"><a href="http://<?= $developer['portfolio']; ?>"><?php $url = preg_replace("(https?://)", "", $developer["portfolio"] ); echo $url ?></a></h4>
						<p><?= $developer['bio']; ?></p>
					</div>