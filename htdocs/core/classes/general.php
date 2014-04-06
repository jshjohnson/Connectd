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
		public function errorView($users, $general, $e) {
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
		 * Checks if there is any file in the directory with the same name as the file that you want to put there. 
		 * If there is a duplicate, a number will be appended to the fule
		 *
		 * @param string $path
		 * @param string $filename
		 * @return void
		 */ 
		public function fileNewPath($path, $filename){
			if ($pos = strrpos($filename, '.')) {
				$name = substr($filename, 0, $pos);
				$ext = substr($filename, $pos);
			} else {
				$name = $filename;
			}

			$newpath = $path.'/'.$filename;
			$newname = $filename;
			$counter = 0;

			while (file_exists($newpath)) {
				$newname = $name .'_'. $counter . $ext;
				$newpath = $path.'/'.$newname;
				$counter++;
			}

			return $newpath;
		}

		public function sendConfirmationEmail($firstName, $email, $emailCode) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); 
				$mail->Username           = "hello@connectd.io";
				$mail->Password           = "kerching27"; 
				$mail->SMTPAuth           = true;            
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  
				$mail->Port               = 587; 
				$mail->addAddress($to);  

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$mail->isHTML(true); 

				$mail->Subject            = 'Activate your new Connectd account';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				$mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $emailCode . "</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}
	    }


		public function sendVoteEmail($firstName, $email, $votes) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); 
				$mail->Username           = "hello@connectd.io";
				$mail->Password           = "kerching27";
				$mail->SMTPAuth           = true; 
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";
				$mail->Port               = 587; 
				$mail->addAddress($to);

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo('hello@connectd.io', 'Contact Connectd.io');
		
				$mail->isHTML(true); 

				$mail->Subject            = 'You just got a vote on Connectd Trials!';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>Congratulations - Someone has voted for you on Connectd Trials. </p>";
				$mail->Body              .= "<p>You now have <strong>" . $votes['CountOfvote_id'] . "/10</strong> votes</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}
	    }

		public function sendMessageEmail($firstName, $email, $message, $sentBy) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); 
				$mail->Username           = "hello@connectd.io"; 
				$mail->Password           = "kerching27"; 
				$mail->SMTPAuth           = true;            
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  
				$mail->Port               = 587; 
				$mail->addAddress($to);  

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$mail->isHTML(true); 

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
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}
	    }

		public function sendRecoverPasswordEmail($email, $firstName, $generated_string) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); 
				$mail->Username           = "hello@connectd.io"; 
				$mail->Password           = "kerching27"; 
				$mail->SMTPAuth           = true;            
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  
				$mail->Port               = 587; 
				$mail->addAddress($to);  

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$mail->isHTML(true); 

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
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}
	    }

		public function sendNewPasswordEmail($email, $firstName, $generated_password) {
		
			global $mail;

			$to = $email;

			try {
				$mail->IsSMTP(); 
				$mail->Username           = "hello@connectd.io"; 
				$mail->Password           = "kerching27"; 
				$mail->SMTPAuth           = true;            
				$mail->SMTPSecure         = "tls"; 
				$mail->Host               = "smtp.gmail.com";  
				$mail->Port               = 587; 
				$mail->addAddress($to);  

				$mail->From               = 'hello@connectd.io';
				$mail->FromName           = 'Connectd.io';
				$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$mail->isHTML(true); 

				$mail->Subject            = 'Recover password -  Connectd.io';

				$mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$mail->Body              .= "<p>Your your new password is: <b>" . $generated_password . "</b></p>";
				$mail->Body              .= "<p>Please change your password once you have logged in using this password.</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}
	    }

		// public function sendEmail($to, $subject, $message, $mail) {

		// 	$to = $email;

		// 	try {
		// 		$mail->IsSMTP(); 
		// 		$mail->Username           = "hello@connectd.io"; 
		// 		$mail->Password           = "kerching27"; 
		// 		$mail->SMTPAuth           = true;            
		// 		$mail->SMTPSecure         = "tls"; 
		// 		$mail->Host               = "smtp.gmail.com";  
		// 		$mail->Port               = 587; 
		// 		$mail->addAddress($to);  

		// 		$mail->From               = 'hello@connectd.io';
		// 		$mail->FromName           = 'Connectd.io';
		// 		$mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
		// 		$mail->isHTML(true); 

		// 		$mail->MsgHTML($message);

		// 		$mail->Subject = $subject;

		// 		$mail->Send();

		// 	}catch(phpmailerException $e) {
		// 		$general = new General($db);
		// 		$general->errorView($general, $e);
		// 	}catch(Exception $e) {
		// 		$general = new General($db);
		// 		$general->errorView($general, $e);
		// 	}
	 //    }

	 //    public function sendConfirmationEmail($arg1, $arg2, $arg3) {
	 //    	$message = file_get_contents('email_templates/register.html');
	 //    	$this->sendEmail($subject, $message);
	 //    }

	}