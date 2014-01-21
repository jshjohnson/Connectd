<?php
	
	function get_job_list_view($job_id, $job) {

		$budget = $job['budget'];
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
		$output = $output . "<a href='" . BASE_URL . "jobs/index.php?id=" . $job_id . "'><p class='media__body'>" . $job['jobtitle'] . "</p></a>";
		$output = $output . "</div>";
		$output = $output . "<div class='media-1-3 media__side'>";
		$output = $output . "<p><small>Posted " . $job['date'] . "</small></p>";
		$output = $output . "<p><small>Username</small></p>";
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

		require(ROOT_PATH . "inc/db_connect.php");

		try {
			$results = $db->query("SELECT jobtitle, budget, date, jobdescription FROM connectdDB.jobs ORDER BY date DESC");
		} catch (Exception $e) {
			echo "Data could not be retrieved";
			exit;
		}
		
		$jobs = $results->fetchAll(PDO::FETCH_ASSOC);

		return $jobs;

	}