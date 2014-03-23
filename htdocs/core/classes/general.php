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
		 * Show PHP errors
		 *
		 * @param  void
		 * @return void
		 */ 
		public function errorView($general, $e) {
			$pageTitle = 'Error';
			$pageType = 'Page';
			$section = 'Blue';
			include('../includes/header.inc.php');
			include('../views/error.html');
			include('../includes/footer.inc.php');
			exit();
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

	    public function sendEmail($firstname, $email, $emailCode) {
	    	global $mail;

	    	$to = $email;

			$mail->Host               = DB_EMAIL;  // specify main and backup server
			$mail->Username           = "josh@joshuajohnson.co.uk";  // SMTP username
			$mail->Password           = "cheeseball27"; // SMTP password
			$mail->SMTPAuth           = true;               // enable SMTP authentication
			$mail->SMTPSecure         = "tls"; 
			$mail->addAddress($to);  // Add a recipient=
            
            $mail->From               = 'robot@connectd.io';
			$mail->FromName           = 'Connectd.io';
            // Set word wrap to 50 characters
			$mail->isHTML(true); // Set email format to HTML

			$mail->Subject            = 'Activate your new Connectd account';

			$mail->Body               = "<p>Hey " . $firstname . "!</p>";
			$mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
			$mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $emailCode . "</p>";
			$mail->Body              .= "<p>-- Connectd team</p>";
			$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
			$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

			if(!$mail->send()) {
			   echo 'Message could not be sent.';
			   echo 'Mailer Error: ' . $mail->ErrorInfo;
			   exit;
			}
	    }

	}