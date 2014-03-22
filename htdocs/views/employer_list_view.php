			<div class='media'>
				<!-- <a href='<?= BASE_URL . "employer/profile.php?id=" . $employer_id; ?>"'><img src='" . $employer['avatar'] . "' alt='' class='media__img media__img--avatar'></a> -->
				<a href='<?=  BASE_URL . "employers/" . $employer['user_id'];?>/'><img src='<?= BASE_URL ?>assets/avatars/default_avatar.png' alt='' class='media__img media__img--avatar'></a>
				<div class='media__body'>
					<div class='float-left user-info'>
						<a href='#'><i class='icon--star'></i></a><a href="<?= BASE_URL . 'employers/' . $employer['user_id'] . '/' ?>"><h4><?= $employer['employer_name']; ?></h4></a>
						<p><?= $employer['employer_type']; ?></p>
					</div>
				</div>
			</div>