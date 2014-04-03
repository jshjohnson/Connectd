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
			include(ROOT_PATH . 'includes/header.inc.php');
			include(ROOT_PATH . 'views/error/error.html');
			include(ROOT_PATH . 'includes/footer.inc.php');
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
		 * If a user has checked "Remember me", set a cookie
		 *
		 * @param  
		 * @return boolean
		 */ 
		public function rememberMe($remember, $email, $year) {
			if($remember) {
				setcookie('remember_me', $email, $year);
			} elseif(!$remember) {
				if(isset($_COOKIE['remember_me'])) {
					$past = time() - 100;
					setcookie(remember_me, gone, $past);
				}
			}
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
			// Unset all of the session variables.
			$_SESSION = array();
			// Destroy the session
			session_destroy();
			header('Location: login.php?status=logged');
	    }

		public function sendConfirmationEmail($firstName, $email, $emailCode) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Username           = "hello@connectd.io";  // SMTP username
				$mail->Password           = "kerching27"; // SMTP password
				$mail->SMTPAuth           = true;               // enable SMTP authentication
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  // sets GMAIL as the SMTP server
				$mail->Port               = 587; 
				$mail->addAddress($to);  // Add a recipient

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				// Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject            = 'Activate your new Connectd account';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				$mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $emailCode . "</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}catch(Exception $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
	    }


		public function sendVoteEmail($firstName, $email, $votes) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Username           = "hello@connectd.io";  // SMTP username
				$mail->Password           = "kerching27"; // SMTP password
				$mail->SMTPAuth           = true;               // enable SMTP authentication
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  // sets GMAIL as the SMTP server
				$mail->Port               = 587; 
				$mail->addAddress($to);  // Add a recipient

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				// Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject            = 'You just got a vote on Connectd Trials!';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>Congratulations - Someone has voted for you on Connectd Trials. </p>";
				$mail->Body              .= "<p>You now have <strong>" . $votes['CountOfvote_id'] . "/10</strong> votes</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}catch(Exception $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
	    }

		public function sendMessageEmail($firstName, $email, $message, $sentBy) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Username           = "hello@connectd.io";  // SMTP username
				$mail->Password           = "kerching27"; // SMTP password
				$mail->SMTPAuth           = true;               // enable SMTP authentication
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  // sets GMAIL as the SMTP server
				$mail->Port               = 587; 
				$mail->addAddress($to);  // Add a recipient

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				// Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject            = 'You just got a message via Connectd!';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>You have been sent a message by <b>" . $sentBy . "</b></p>";
				$mail->Body              .= "<p>Message:</p>";
				$mail->Body              .= "<p>" . $message . "</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}catch(Exception $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
	    }

		public function sendRecoverPasswordEmail($email, $firstName, $generated_string) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Username           = "hello@connectd.io";  // SMTP username
				$mail->Password           = "kerching27"; // SMTP password
				$mail->SMTPAuth           = true;               // enable SMTP authentication
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  // sets GMAIL as the SMTP server
				$mail->Port               = 587; 
				$mail->addAddress($to);  // Add a recipient

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				// Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject            = 'Recover password -  Connectd.io';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>Please click the link below to reset your password:</p>";
				$mail->Body              .= "<p>" . BASE_URL . "recover.php?email=" . $email . "&generated_string=" . $generated_string . "</p>";
				$mail->Body              .= "<p>We will generate a new password for you and send it back to your email.</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}catch(Exception $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
	    }

		public function sendNewPasswordEmail($email, $firstName, $generated_password) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Username           = "hello@connectd.io";  // SMTP username
				$mail->Password           = "kerching27"; // SMTP password
				$mail->SMTPAuth           = true;               // enable SMTP authentication
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  // sets GMAIL as the SMTP server
				$mail->Port               = 587; 
				$mail->addAddress($to);  // Add a recipient

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				// Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject            = 'Recover password -  Connectd.io';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>Your your new password is: <b>" . $generated_password . "</b></p>";
				$mail->Body              .= "<p>Please change your password once you have logged in using this password.</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}catch(Exception $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
	    }
	}