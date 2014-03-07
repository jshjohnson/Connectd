<?php 	
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->loggedOutProtect();

	$pageTitle = "Trials";
	$section = "Trials";

	$trial_users 		= $users->getTrialUsers();
	$trial_users_count   = count($members);

	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/page-header.php");
?>
		<section class="container">
			<div class="grid cf">
			<?php foreach ($trial_users as $trial_user) : ?>
				<aside class="grid__cell module-1-4 push-bottom">
					<article class="user-sidebar module--no-pad">
						<?php  if(strtotime(date('F j, Y', $trial_user['time_joined']))>strtotime('-3 days')) : ?>
						     <div class="ribbon"><h5>New</h5></div>
						<?php endif ?>
						<div class="user-sidebar__info">
							<h3 class="user-sidebar__title user-sidebar__title--alt"><?= $trial_user["firstname"] . "\n" . $trial_user["lastname"]; ?></h3>
							<h4 class="user-sidebar__label icon--attach icon--marg"><?= $trial_user["jobtitle"]; ?></h4>
							<h4 class="user-sidebar__label icon--location icon--marg"><?= $trial_user["location"]; ?>, UK</h4>
							<h4 class="user-sidebar__label icon--briefcase icon--marg"><?php $url = preg_replace("(Between)", "", $trial_user["experience"] ); echo $url ?> experience</h4>
							<h4 class="user-sidebar__label icon--globe icon--marg"><a href="<?= $trial_user["portfolio"]; ?>"><?php $url = preg_replace("(https?://)", "", $trial_user["portfolio"] ); echo $url ?></a></h4>
							<div class="button-wrapper">
								<a href="add-vote.php?user_id=<?= $trial_user["user_id"]; ?>" class="btn btn--green btn--small">
									 <span class="icon--check"><?= $trial_user["votes"]; ?> votes</span>
								</a>
							</div>
						</div>
					</article>
				</aside>
			<?php endforeach; ?>
			</div>
		</section>
		<section class="call-to-action footer-push">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for freelance work?
				</h4>
				<a class="btn btn--green" href="<?= BASE_URL; ?>dashboard/">See our jobs list</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>