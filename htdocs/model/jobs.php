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
		$output = $output . "<a href='" . BASE_URL . "jobs/" . $job['job_id'] . "/'><p class='media__body'>" . $job['job_name'] . "</p></a>";
		$output = $output . "</div>";
		$output = $output . "<div class='media-1-3 media__side'>";
		$output = $output . "<p><small>" . date('F j, Y', $job['job_post_date']) . "</small></p>";
		$output = $output . "<p><small><strong><a href='" . BASE_URL . $job['user_type'] . "s/" . $job['user_id'] . "/" . "'>" . $job['employer_name'] . "</strong></a></small></p>";
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
				j.*, u.user_id, ut.user_type_id, ut.user_type, e.employer_name
				FROM (((" . DB_NAME . ".jobs AS j
				LEFT JOIN " . DB_NAME . ".users AS u
				ON j.user_id = u.user_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON j.user_id = ut.user_type_id)
				LEFT JOIN " . DB_NAME . ".employers AS e 
				ON j.user_id = e.employer_id)
			");
			$results->execute();
		} catch (Exception $e) {
			echo "Damn. All job data could not be retrieved";
			exit;
		}
		
		$jobs = $results->fetchAll(PDO::FETCH_ASSOC);

		return $jobs;

	}

	function get_jobs_single($id) {

		require(ROOT_PATH . "core/connect/database.php");

		try {
			$results = $db->prepare("SELECT
				j.*, u.user_id, u.location, u.portfolio, u.bio, u.time_joined, e.employer_name, et.employer_type
				FROM (((" . DB_NAME . ".jobs AS j
				INNER JOIN " . DB_NAME . ".users AS u 
				ON j.user_id = u.user_id)
				INNER JOIN " . DB_NAME . ".employers AS e 
				ON j.user_id = e.employer_id)
				INNER JOIN " . DB_NAME . ".employer_types AS et 
				ON j.user_id = et.employer_type_id)
				WHERE j.job_id = ?
			");
			$results->bindValue(1, $id);
			$results->execute();
		} catch (Exception $e) {
			echo "Damn. Single job data could not be retrieved.";
			exit;
		}

		$jobs = $results->fetch(PDO::FETCH_ASSOC);
		
		return $jobs;
	}