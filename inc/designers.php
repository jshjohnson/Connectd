<?php

	$query = "SELECT * FROM connectdDB.designers";

	$result = mysqli_query($db_server, $query);

	if (!$result) die("Database access failed: " . mysqli_error($db_server));

	$designers = $result;

	// $designers = array();
	// $designers[101] = array(
	// 	"avatar" => "http://placehold.it/350/300",
	// 	"firstname" => "Harry",
	// 	"lastname" => "Fox",
	// 	"jobtitle" => "Graphic Designer",
	// 	"location" => "Hertfordshire, UK",
	// 	"portfolio" => "http://harryfox.com",
	// 	"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
	// );
	// $designers[102] = array(
	// 	"avatar" => "http://placehold.it/350/300",
	// 	"firstname" => "Josh",
	// 	"lastname" => "Johnson",
	// 	"jobtitle" => "Graphic Designer",
	// 	"location" => "Essex, UK",
	// 	"portfolio" => "http://harryfox.com",
	// 	"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
	// );
	// $designers[103] = array(
	// 	"avatar" => "http://placehold.it/350/300",
	// 	"firstname" => "Patrick",
	// 	"lastname" => "Manderson",
	// 	"jobtitle" => "Illustrator",
	// 	"location" => "Cumbria, UK",
	// 	"portfolio" => "http://patrickmanderson.com",
	// 	"bio" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, sequi, eius, similique, sint amet iusto nostrum sed harum quam quod voluptates laborum accusantium voluptas provident explicabo expedita aperiam perferendis eos."
	// );