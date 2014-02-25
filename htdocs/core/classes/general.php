<?php 
	class General{

		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	 
		public function errors() {
			error_reporting(E_ERROR|E_WARNING);
			ini_set('display_errors', 1);
		}

		public function closeDB() {
			$db = NULL;
		}

		// Strip data from malicious data
		public function clean_string($db = null, $string){
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
		public function salt($string) { 
			$salt1 = 'a9*g4qwgrsht';
			$salt2 = 'bu59304fh8ura0';
			$salted = sha1("$salt1$string$salt2");
			return $salted;
		}


	    public function showErrors() {
	    	error_reporting(E_ERROR|E_WARNING);
	    }

	    // Simply starts the session. 
	    public function doStartSession() {
	        session_start();
	    }

	    // Test if user is logged in @boolean
		public function logged_in () {
			return(isset($_SESSION['id'])) ? true : false;
		}
	 
		// Check if user is logged in, if so direct them to the dashboard
		public function logged_in_protect() {
			if ($this->logged_in() === true) {
				header("Location:" . BASE_URL . "dashboard/");
				exit();		
			}
		}
		
		// Check if user is logged out, if so direct them to the homepage
		public function logged_out_protect() {
			if ($this->logged_in() === false) {
				header("Location:" . BASE_URL);
				exit();
			}	
		}

	    // Logs the user out 
	    public function doLogout() {
			session_start();
			// Unset all of the session variables.
			$_SESSION = array();
			// Destroy the session
			session_destroy();
			header('Location: sign-in.php?status=logged');
	    }


	    public function getCounties() {

			$query = $this->db->prepare("SELECT county FROM " . DB_NAME . ".locations ORDER BY county ASC");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	    }
	 
	}