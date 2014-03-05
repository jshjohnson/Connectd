<?php
	
	function get_job_list_view($job_id, $job) {

		$budget = $job['job_budget'];
		$output = "";

		$output = $output . "<div class='media'>";
		$output = $output . "<div class='media__desc media-2-3'>";
		$output = $output . "<div class='media__button currency-button'>";
		$output = $output . "<span class='currency'>";

		if ($budget>=10000) {
			$output = $output . "£" . substr($budget, 0, 2) . "k";
		} elseif ($budget>=1000) {
			$output = $output . "£" . substr($budget, 0, 1) . "k";
		} else {
			$output = $output . "£" . $budget;
		}

		$output = $output . "</span>";
		$output = $output . "</div>";
		$output = $output . "<a href='" . BASE_URL . "jobs/" . $job_id . "/'><p class='media__body'>" . $job['job_name'] . "</p></a>";
		$output = $output . "</div>";
		$output = $output . "<div class='media-1-3 media__side'>";
		$output = $output . "<p><small>" . date('F j, Y', $job['job_post_date']) . "</small></p>";
		$output = $output . "<p><small><a href='" . BASE_URL . $job['user_type'] . "s/" . $job['user_id'] . "/" . "'>" . $job['firstname'] . ' ' .  $job['lastname'] . "</a></small></p>";
		$output = $output . "</div>";
		$output = $output . "</div>";

		return $output;
	}

	function get_jobs_recent() {

		$recent = "";
		$all = get_jobs_all();

		$total_jobs = count($all);
		$position = 0;
		$list_view = "";

		foreach ($all as $job) {
			$position = $position + 1;
			// if designer is one of the 4 most recent jobs
			if ($total_jobs - $position < 6) {
				$recent[] = $job;
			}
		}
		return $recent;
	}

	function get_jobs_all() {

		require(ROOT_PATH . "core/connect/database.php");

		try {
			$results = $db->query("SELECT 
				jobs.job_id, users.user_id, jobs.job_name, jobs.job_budget, jobs.job_post_date, jobs.job_description, jobs.job_category, users.firstname, users.lastname, users.user_type
				FROM jobs, users WHERE users.user_id = jobs.user_id");
		} catch (Exception $e) {
			echo "Data could not be retrieved";
			exit;
		}
		
		$jobs = $results->fetchAll(PDO::FETCH_ASSOC);

		return $jobs;

	}