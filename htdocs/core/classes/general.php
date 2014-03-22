<?php 
	class General {

		// Properties
		
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		}
	 
	 	/**
		 * Show PHP errors
		 *
		 * @param  void
		 * @return void
		 */ 
		public function errors() {
			error_reporting(E_ERROR|E_WARNING);
			ini_set('display_errors', 1);
		}

	 	/**
		 * Strip data from malicious data
		 *
		 * @param  void
		 * @return string
		 */ 
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

		/**
		 * Prevent form hijacking
		 *
		 * @param  void
		 * @return void
		 */ 
		public function hijackPrevention() {
			foreach( $_POST as $value ){
	            if( stripos($value,'Content-Type:') !== FALSE ){
	                $errors[] = "Hmmmm. Are you a robot? Try again.";
	            }
	        }
		}

	 	/**
		 *  Present time in terms of years, days, weeks, minutes or seconds ago
		 *
		 * @param  int $i The time a user signed up (`time_joined`)
		 * @return string
		 */ 
		public function timeAgo($i){
			$m = time()-$i; $o='just now';
			$t = array('year'=>31556926,'month'=>2629744,'week'=>604800,
			'day'=>86400,'hour'=>3600,'minute'=>60,'second'=>1);
			foreach($t as $u=>$s){
				if($s<=$m){$v=floor($m/$s); $o="$v $u".($v==1?'':'s').' ago'; break;}
			}
			return $o;
		}
				
	 	/**
		 * Test if user is logged in
		 *
		 * @param  void
		 * @return boolean
		 */ 
		public function loggedIn() {
			return(isset($_SESSION['user_id'])) ? true : false;
		}
	 
	 	/**
		 * If used is logged in, redirect them appropriately
		 *
		 * @param  void
		 * @return void
		 */ 
		public function loggedInProtect() {
			if ($this->loggedIn() === true) {
				header("Location:" . BASE_URL . "dashboard/");
				exit();		
			}
		}
		
	 	/**
		 * Check if user is logged out, if so direct them to the homepage
		 *
		 * @param  void
		 * @return boolean
		 */ 
		public function loggedOutProtect() {
			if ($this->loggedIn() === false) {
				header("Location:" . BASE_URL);
				exit();
			}	
		}
		
	 	/**
		 * Performs user log out
		 *
		 * @param  void
		 * @return void
		 */ 
	    public function doLogout() {
			session_start();
			// Unset all of the session variables.
			$_SESSION = array();
			// Destroy the session
			session_destroy();
			header('Location: login.php?status=logged');
	    }

	}