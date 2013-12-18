<?php

	$query = "SELECT * FROM connectdDB.designers";

	$result = mysqli_query($db_server, $query);

	if (!$result) die("Database access failed: " . mysqli_error($db_server));