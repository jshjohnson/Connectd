<?php

	function get_employer_list_view($employer_id, $employer) {

		$output = "";

		$output = $output . "<div class='media'>";
		// $output = $output . "<a href='" . BASE_URL . "employer/profile.php?id=" . $employer_id . "'><img src='" . $employer['avatar'] . "' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<a href='" . BASE_URL . "employers/" . $employer['user_id'] . "/'><img src='" . BASE_URL . "assets/avatars/default_avatar.png' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<div class='media__body'>";
		$output = $output . "<div class='float-left user-info'>";
		$output = $output . "<a href='#'><i class='icon--star'></i></a><a href='" . BASE_URL . "employers/" . $employer['user_id'] . "/'><h4>" . $employer['firstname'] . ' ' . $employer['lastname'] . "</h4></a>";
		$output = $output . "<p>" . $employer['jobtitle'] . "</p>";
		$output = $output . "</div>";
		$output = $output . "<div class='float-right price-per-hour'>";
		$output = $output . "<h5>£" . $employer['priceperhour'] ."</h5>";
		$output = $output . "<span>per hour</span>";
		$output = $output . "</div>";
		$output = $output . "</div>";
		$output = $output . "</div>";

		return $output;
	}


	function get_employers_recent() {

		$recent = "";
		$all = get_employers_all();

		$total_employers = count($all);
		$position = 0;
		$list_view = "";

		foreach ($all as $employer) {
			$position = $position + 1;
			// if designer is one of the 4 most recent designers
			if ($total_employers - $position < 6) {
				$recent[] = $employer;
			}
		}
		return $recent;
	}

	function get_employers_all() {
		
		require(ROOT_PATH . "core/connect/database.php");

		try {
			$results = $db->query("SELECT * FROM " . DB_NAME . ".users WHERE `confirmed` = 1 AND `user_type` = 'employer'");
		} catch (Exception $e) {
			echo "Data could not be retrieved";
			exit;
		}
		
		$employers = $results->fetchAll(PDO::FETCH_ASSOC);

		return $employers;

	}

	function get_employers_single($id) {

		require(ROOT_PATH . "core/connect/database.php");

		try {
			$results = $db->prepare("SELECT 
				* 
				FROM " . DB_NAME . ".users u
				INNER JOIN " . DB_NAME . ".jobs j on u.user_id = j.user_id
				INNER JOIN " . DB_NAME . ".employers e ON u.user_id = e.user_id
				WHERE u.user_id = ? AND `user_type` = ?
			");
			$results->bindValue(1, $id);
			$results->bindValue(2, 'employer');
			$results->execute();
		} catch (Exception $e) {
			echo "Damn. Data could not be retrieved.";
			exit;
		}

		$employers = $results->fetch(PDO::FETCH_ASSOC);
		
		return $employers;
	}