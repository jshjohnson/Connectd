<?php

	function get_employer_list_view($employer_id, $employer) {

		$output = "";

		$output = $output . "<div class='media'>";
		// $output = $output . "<a href='" . BASE_URL . "employer/profile.php?id=" . $employer_id . "'><img src='" . $employer['avatar'] . "' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<a href='" . BASE_URL . "employers/" . $employer['user_id'] . "/'><img src='" . BASE_URL . "assets/avatars/default_avatar.png' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<div class='media__body'>";
		$output = $output . "<div class='float-left user-info'>";
		$output = $output . "<a href='#'><i class='icon--star'></i></a><a href='" . BASE_URL . "employers/" . $employer['user_id'] . "/'><h4>" . $employer['employer_name'] . "</h4></a>";
		$output = $output . "<p>" . $employer['employer_type'] . "</p>";
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
			$results = $db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, e.employer_id, e.employer_name, ut.*, et.*
				FROM (((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".employers AS e
				ON u.user_id = e.employer_id)
				LEFT JOIN " . DB_NAME . ".employer_types as et
				ON u.user_id = et.employer_type_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = ?
				AND ut.user_type = ?
			");
			$results->bindValue(1, 1);
			$results->bindValue(2, 'employer');

			$results->execute();
		} catch (Exception $e) {
			echo "Damn. All employer data could not be retrieved.";
			exit;
		}
		
		$employers = $results->fetchAll(PDO::FETCH_ASSOC);

		return $employers;

	}

	function get_employers_single($id) {

		require(ROOT_PATH . "core/connect/database.php");

		try {
			$results = $db->prepare("
				SELECT *
				FROM " . DB_NAME . ".users, " . DB_NAME . ".employers
				WHERE `confirmed` = ? 
				AND users.user_id = ?
				AND users.user_id = employers.user_id
			");

			$results->bindValue(1, 1);
			$results->bindValue(2, $id);
			$results->bindValue(3, 'employer');

			$results->execute();
		} catch (Exception $e) {
			echo "Damn. Single employer data could not be retrieved.";
			exit;
		}

		$employers = $results->fetch(PDO::FETCH_ASSOC);
		
		return $employers;
	}

?>