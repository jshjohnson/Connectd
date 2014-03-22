		<?php
			$budget = $job['job_budget'];
			$output = "";
		?>
			<div class='media'>
				<div class='media__desc media-2-3 media-2-3--wide'>
					<div class='media__button currency-button'>
						<span class='currency'>
						<?php 
							if ($budget>=10000) {
								echo "£" . substr($budget, 0, 2) . "k";
							} elseif ($budget>=1000) {
								echo "£" . substr($budget, 0, 1) . "k";
							} else {
								echo "£" . $budget;
							}
						?>
						</span>
					</div>
					<a href="<?= BASE_URL . "jobs/" . $job['job_id']; ?>/"><p class='media__body'><?= $job['job_name']; ?></p></a>
				</div>
				<div class='media-1-3 media__side'>
					<p><small><?= date('F j, Y', $job['job_post_date']); ?></small></p>
					<p><small><strong><a href="<?= BASE_URL . $job['user_type'] . 's/' . $job['user_id']; ?>/"><?= $job['employer_name']; ?></a></strong></small></p>
				</div>
			</div>