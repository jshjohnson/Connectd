<?php 
	class General {

		// Properties
		
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		}
	 
		public function errors() {
			error_reporting(E_ERROR|E_WARNING);
			ini_set('display_errors', 1);
		}

		// Strip data from malicious data
		public function cleanString($db = null, $string){
			$string = trim($string, " \t\0\x0B");
			$string = utf8_decode($string);
			$string = str_replace("#", "&#35", $string);
			$string = str_replace("%", "&#37", $string);
			if (get_magic_quotes_gpc()) {
				$string = stripslashes($string);
			}
			return htmlentities($string);
		}

		// Form hijack prevention
		public function hijackPrevention() {
			foreach( $_POST as $value ){
	            if( stripos($value,'Content-Type:') !== FALSE ){
	                $errors[] = "Hmmmm. Are you a robot? Try again.";
	            }
	        }
		}

		public function timeAgo($tm,$rcs = 0) {
		   $cur_tm = time(); $dif = $cur_tm-$tm;
		   $pds = array('second','minute','hour','day','week','month','year','decade');
		   $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
		   for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

		   $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
		   if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
		   return $x;
		}
				
	    // Test if user is logged in @boolean
		public function loggedIn() {
			return(isset($_SESSION['user_id'])) ? true : false;
		}
	 
		// Check if user is logged in, if so direct them to the dashboard or welcome page
		public function loggedInProtect() {
			if ($this->loggedIn() === true) {
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
			header('Location: login.php?status=logged');
	    }

	    public function getJobTitles($userType) {

	    	if ($userType == "Developer") {

		    	$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".developer_titles LIKE 'job_title'");
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
				}
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				preg_match_all("/'(.*?)'/", $row['Type'], $categories);
				$fields = $categories[1];
				return $fields;

	    	} else if ($userType == "Designer") {
		    	$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".designer_titles LIKE 'job_title'");
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
				}
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				preg_match_all("/'(.*?)'/", $row['Type'], $categories);
				$fields = $categories[1];
				return $fields;
	    	}
	    }

	}