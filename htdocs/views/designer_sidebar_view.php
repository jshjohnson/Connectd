					<div class="badge badge--left color-red">
						<span class="badge__inner">
							<h5>£<?= $designer['priceperhour']; ?></h5>
							<small>per hour</small>
						</span>
					</div>
					<div class="user-module__header">
						<div class="user-module__avatar">
							<img src="http://placehold.it/400x400" alt="">
						</div>
						<div class="button-wrapper">
							<a class="button--left btn btn--green cf hire-trigger" href="mailto:<?= $designer['email']; ?>?subject=I would like to hire you! -- Connectd&body=Hey <?= $designer['firstname']; ?>...">Hire <?= $designer['firstname']; ?></a>
							<a class="button--right btn btn--blue cf hire-trigger" href="mailto:<?= $designer['email']; ?>?subject=I would like to collaborate with you! -- Connectd&body=Hey <?= $designer['firstname']; ?>..."?>Collaborate</a>
						</div>
					</div>
					<div class="user-module__info">
						<a href=""><i class="icon--star"></i></a><h3 class="user-module__title"><?= $designer['firstname'] . " " . $designer['lastname']; ?></h3>
						<h4 class="user-module__label icon--attach icon--marg"><?= $designer['jobtitle']; ?></h4>
						<h4 class="user-module__label icon--location icon--marg"><?= $designer['location']; ?></h4>
						<h4 class="user-module__label icon--globe icon--marg"><a href="http://<?= $designer['portfolio']; ?>"><?php $url = preg_replace("(https?://)", "", $designer["portfolio"] ); echo $url ?></a></h4>
						<p><?= $designer['bio']; ?></p>
					</div>