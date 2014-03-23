<?php 
	# We are storing the information in this config array that will be required to connect to the database.
	$config = array(
		'host'		=> DB_HOST,
		'username'	=> DB_USER,
		'password'	=> DB_PASS,
		'dbname' 	=> DB_NAME
	);

	try {
		#connecting to the database by supplying required parameters
		$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);

		#Setting the error mode of our db object, which is very important for debugging.
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e) {
		$pageTitle = 'Error';

		include(BASE_URL . 'includes/header.inc.php');
		include(BASE_URL . 'views/error.html');
		include(BASE_URL . 'includes/footer.inc.php');
		
		exit();
	}
?>