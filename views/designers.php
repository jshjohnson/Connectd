<?php


	function get_designer_list_view($designer_id, $designer) {

		$output = "";

		$output = $output . "<div class='media'>";
		// $output = $output . "<a href='" . BASE_URL . "designer/profile.php?id=" . $designer_id . "'><img src='" . $designer['avatar'] . "' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<a href='" . BASE_URL . "developer/profile.php?id=" . $designer_id . "'><img src='http://placehold.it/200x200' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<div class='media__body'>";
		$output = $output . "<div class='float-left user-info'>";
		$output = $output . "<a href='#'><i class='icon--star'></i></a><a href='" . BASE_URL . "designer/profile.php?id=" . $designer_id . "'><h4>" . $designer['firstname'] . ' ' . $designer['lastname'] . "</h4></a>";
		$output = $output . "<p>" . $designer['jobtitle'] . "</p>";
		$output = $output . "</div>";
		$output = $output . "<div class='float-right price-per-hour'>";
		$output = $output . "<h5>£36</h5>";
		$output = $output . "<span>per hour</span>";
		$output = $output . "</div>";
		$output = $output . "</div>";
		$output = $output . "</div>";

		return $output;
	}

	function get_designers_recent() {

		$recent = "";
		$all = get_designers_all();

		$total_designers = count($all);
		$position = 0;
		$list_view = "";

		foreach ($all as $designer) {
			$position = $position + 1;
			// if designer is one of the 4 most recent designers
			if ($total_designers - $position < 6) {
				$recent[] = $designer;
			}
		}
		return $recent;
	}

	function get_designers_all() {

		require(ROOT_PATH . "inc/db_connect.php");

		try {
			$results = $db->query("SELECT * FROM connectdDB.designers");
		} catch (Exception $e) {
			echo "Data could not be retrieved";
			exit;
		}
		
		$designers = $results->fetchAll(PDO::FETCH_ASSOC);

		return $designers;

	}

?>