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
		public function cleanString($db = null, $string){
			$string = trim($string);
			$string = utf8_decode($string);
			$string = str_replace("#", "&#35", $string);
			$string = str_replace("%", "&#37", $string);
			if (get_magic_quotes_gpc()) {
				$string = stripslashes($string);
			}
			return htmlentities($string);
		}

		// Test if user has been verified into the community
		public function userVotedFor($email) {
 
			$query = $this->db->prepare("SELECT designers.email
						FROM " . DB_NAME . ".designers 
						WHERE designers.votes >= ? 
						UNION SELECT developers.email
						FROM " . DB_NAME . ".developers 
						WHERE developers.votes >= ?
					");
			$query->bindValue(1, 10);
			$query->bindValue(2, 10);
			
			try{
				
				$query->execute();
				$rows = $query->fetchColumn();
		 
				if($rows == 1){
					return true;
				}else{
					return false;
				}
		 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}


		public function userVotedForProtect() {

			if($this->userVotedFor($email) === true) {
				#Redirect the user to the dashboard
				header("Location:" . BASE_URL . "dashboard/");
				exit();
			} else if($this->userVotedFor($email) === false) {
				header("Location:" . BASE_URL . "welcome/");
				exit();
			}
		} 

	    // Test if user is logged in @boolean
		public function loggedIn() {
			return(isset($_SESSION['id'])) ? true : false;
		}
	 
		// Check if user is logged in, if so direct them to the dashboard or welcome page
		public function loggedInProtect() {
			if ($this->loggedIn () === true) {
				header("Location:" . BASE_URL . "dashboard/");
				exit();		
			}
		}
		
		// Check if user is logged out, if so direct them to the homepage
		public function loggedOutProtect() {
			if ($this->loggedIn() === false) {
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

	    public function getBusinessTypes() {
			$query = $this->db->prepare("SELECT business_type FROM " . DB_NAME . ".business_types ORDER BY business_type ASC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	    }


	    public function getJobTitles($userType) {
			$query = $this->db->prepare("SELECT job_title, user_type FROM " . DB_NAME . ".job_titles WHERE user_type = ?");
			$query->bindValue(1, $userType);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	    }	 
	}