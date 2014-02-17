<?php

	$query = "SELECT * FROM " . DB_NAME . ".employers";

	$result = mysqli_query($db_server, $query);

	if (!$result) die("Database access failed: " . mysqli_error($db_server));