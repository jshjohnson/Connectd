<?php

	// $query = "SELECT * FROM connectdDB.designers";

	// $result = mysqli_query($db_server, $query);

	// if (!$result) die("Database access failed: " . mysqli_error($db_server));

	// $designers = $result;

	function get_designer_list_view($designer_id, $designer) {

		$output = "";

		$output = $output . "<div class='media'>";
		$output = $output . "<a href='" . BASE_URL . "designer/profile.php?id=" . $designer_id . "'><img src='" . $designer['avatar'] . "' alt='' class='media__img media__img--avatar'></a>";
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

	$designers = array();
	$designers[101] = array(
		"avatar" => "http://placehold.it/350/300",
		"firstname" => "Harry",
		"lastname" => "Fox",
		"jobtitle" => "Graphic Designer",
		"location" => "Hertfordshire, UK",
		"portfolio" => "http://harryfox.com",
		"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
	);
	$designers[102] = array(
		"avatar" => "http://placehold.it/350/300",
		"firstname" => "Josh",
		"lastname" => "Johnson",
		"jobtitle" => "Graphic Designer",
		"location" => "Essex, UK",
		"portfolio" => "http://harryfox.com",
		"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
	);
	$designers[103] = array(
		"avatar" => "http://placehold.it/350/300",
		"firstname" => "Patrick",
		"lastname" => "Manderson",
		"jobtitle" => "Illustrator",
		"location" => "Cumbria, UK",
		"portfolio" => "http://patrickmanderson.com",
		"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
	);

