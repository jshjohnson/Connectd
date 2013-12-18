<?php

	// $query = "SELECT * FROM connectdDB.developers";

	// $result = mysqli_query($db_server, $query);

	// if (!$result) die("Database access failed: " . mysqli_error($db_server));

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