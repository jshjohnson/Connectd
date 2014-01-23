<?php
	/**
	* Creates a PDO database connection (in this case to a SQLite flat-file database)
	* @return bool Database creation success status, false by default
	*/

	function errors () {
		error_reporting(E_ERROR|E_WARNING);
	}

	function closeDB() {
		$db = NULL;
	}

	// Strip data from malicious data
	function clean_string($db = null, $string){
		$string = trim($string);
		$string = utf8_decode($string);
		$string = str_replace("#", "&#35", $string);
		$string = str_replace("%", "&#37", $string);
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		return htmlentities($string);
	}
	
	// Encrypt password
	function salt($string) { 
		$salt1 = 'a9*g4qwgrsht';
		$salt2 = 'bu59304fh8ura0';
		$salted = md5("$salt1$string$salt2");
		return $salted;
	}

    function showErrors() {
    	error_reporting(E_ERROR|E_WARNING);
    }

    // Simply starts the session. 
    function doStartSession() {
        session_start();
    }

    // Check if user is logged in, if so direct them to the dashboard
    function checkLoggedIn() {
		session_start();
		if (isset($_SESSION['logged'])){
			header("Location:" . BASE_URL . "dashboard/");
		}
    }

    // Check if user is logged out, if so direct them to the homepage
	function checkLoggedOut() {
		session_start();
		if (!isset($_SESSION['logged'])){
			header("Location:" . BASE_URL);
		}
	}

    // Logs the user out 
    function doLogout() {
		session_start();
		// Unset all of the session variables.
		$_SESSION = array();
		// Destroy the session
		session_destroy();
		header('Location: ../sign-in.php?status=logged');
    }
