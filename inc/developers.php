<?php

	function get_developer_list_view($developer_id, $developer) {

		$output = "";

		$output = $output . "<div class='media'>";
		$output = $output . "<a href='" . BASE_URL . "developer/profile.php?id=" . $developer_id . "'><img src='" . $developer['avatar'] . "' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<div class='media__body'>";
		$output = $output . "<div class='float-left user-info'>";
		$output = $output . "<a href='#'><i class='icon--star'></i></a><a href='" . BASE_URL . "developer/profile.php?id=" . $developer_id . "'><h4>" . $developer['firstname'] . ' ' . $developer['lastname'] . "</h4></a>";
		$output = $output . "<p>" . $developer['jobtitle'] . "</p>";
		$output = $output . "</div>";
		$output = $output . "<div class='float-right price-per-hour'>";
		$output = $output . "<h5>£36</h5>";
		$output = $output . "<span>per hour</span>";
		$output = $output . "</div>";
		$output = $output . "</div>";
		$output = $output . "</div>";

		return $output;
	}


	function get_developers_recent() {

		$recent = "";
		$all = get_developers_all();

		$total_developers = count($all);
		$position = 0;
		$list_view = "";

		foreach ($all as $developer) {
			$position = $position + 1;
			// if designer is one of the 4 most recent designers
			if ($total_developers - $position < 6) {
				$recent[] = $developer;
			}
		}
		return $recent;
	}

	function get_developers_all() {

		$developers = array();

		$developers[101] = array(
			"avatar" => "http://placehold.it/350/300",
			"firstname" => "Harry",
			"lastname" => "Fox",
			"jobtitle" => "Front-end Developer",
			"location" => "Hertfordshire, UK",
			"portfolio" => "http://harryfox.com",
			"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
		);
		$developers[102] = array(
			"avatar" => "http://placehold.it/350/300",
			"firstname" => "Josh",
			"lastname" => "Johnson",
			"jobtitle" => "Back-end Developer",
			"location" => "Essex, UK",
			"portfolio" => "http://joshuajohnson.co.uk",
			"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
		);
		$developers[103] = array(
			"avatar" => "http://placehold.it/350/300",
			"firstname" => "Patrick",
			"lastname" => "Manderson",
			"jobtitle" => "Full-stack Developer",
			"location" => "Cumbria, UK",
			"portfolio" => "http://patrickmanderson.com",
			"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
		);

		return $developers;
	}