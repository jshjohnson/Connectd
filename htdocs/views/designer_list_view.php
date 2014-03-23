			<div class='media'>
				<a href="<?= BASE_URL . "designers/" . $designer['user_id']; ?>/"><img src="<?= BASE_URL ?>assets/avatars/default_avatar.png" alt='' class='media__img media__img--avatar'></a>
				<div class='media__body'>
					<div class='float-left user-info'>
						<a href='#'><i class='icon--star'></i></a>
						<a href="<?= BASE_URL . "designers/" . $designer['user_id']; ?>/"><h4><?= $designer['firstname'] . ' ' . $designer['lastname']; ?></h4></a>
						<p><?= $designer['jobtitle']; ?></p>
					</div>
					<div class="float-right badge--price-per-hour">
						<div class="badge__inner">
							<h5>£<?= $designer['priceperhour']; ?></h5>
							<span>per hour</span>
						</div>
					</div>
				</div>
			</div>