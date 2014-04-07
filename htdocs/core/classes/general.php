<?php 
	class General {
		
		// Methods

		public function __construct() {
		    $this->mail = new PHPMailer();
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
		
			$to = $email;

			try {
				$this->mail->IsSMTP(); 
				$this->mail->Username           = "hello@connectd.io";
				$this->mail->Password           = "kerching27"; 
				$this->mail->SMTPAuth           = true;            
				$this->mail->SMTPSecure         = "tls"; 
				$this->mail->Host               = "smtp.gmail.com";  
				$this->mail->Port               = 587; 
				$this->mail->addAddress($to);  

				$this->mail->From               = 'hello@connectd.io';
				$this->mail->FromName           = 'Connectd.io';
				$this->mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$this->mail->isHTML(true); 

				$this->mail->Subject            = 'Activate your new Connectd account';

				$this->mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$this->mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				$this->mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $emailCode . "</p>";
				$this->mail->Body              .= "<p>-- Connectd team</p>";
				$this->mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$this->mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$this->mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}
	    }


		public function sendVoteEmail($firstName, $email, $votes) {

			$to = $email;

			try {
				$this->mail->IsSMTP(); 
				$this->mail->Username           = "hello@connectd.io";
				$this->mail->Password           = "kerching27";
				$this->mail->SMTPAuth           = true; 
				$this->mail->SMTPSecure         = "tls"; 
				$this->mail->Host               = "smtp.gmail.com";
				$this->mail->Port               = 587; 
				$this->mail->addAddress($to);

				$this->mail->From               = 'hello@connectd.io';
				$this->mail->FromName           = 'Connectd.io';
				$this->mail->AddReplyTo('hello@connectd.io', 'Contact Connectd.io');
		
				$this->mail->isHTML(true); 

				$this->mail->Subject            = 'You just got a vote on Connectd Trials!';

				$this->mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$this->mail->Body              .= "<p>Congratulations - Someone has voted for you on Connectd Trials. </p>";
				$this->mail->Body              .= "<p>You now have <strong>" . $votes['CountOfvote_id'] . "/10</strong> votes</p>";
				$this->mail->Body              .= "<p>-- Connectd team</p>";
				$this->mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$this->mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$this->mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}
	    }

		public function sendMessageEmail($firstName, $email, $message, $sentBy) {
		
			$to = $email;

			try {
				$this->mail->IsSMTP(); 
				$this->mail->Username           = "hello@connectd.io"; 
				$this->mail->Password           = "kerching27"; 
				$this->mail->SMTPAuth           = true;            
				$this->mail->SMTPSecure         = "tls"; 
				$this->mail->Host               = "smtp.gmail.com";  
				$this->mail->Port               = 587; 
				$this->mail->addAddress($to);  

				$this->mail->From               = 'hello@connectd.io';
				$this->mail->FromName           = 'Connectd.io';
				$this->mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$this->mail->isHTML(true); 

				$this->mail->Subject            = 'You just got a message via Connectd!';

				$this->mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$this->mail->Body              .= "<p>You have been sent a message by <b>" . $sentBy . "</b></p>";
				$this->mail->Body              .= "<p>Message:</p>";
				$this->mail->Body              .= "<p>" . $message . "</p>";
				$this->mail->Body              .= "<p>-- Connectd team</p>";
				$this->mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$this->mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$this->mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}
	    }

		public function sendRecoverPasswordEmail($email, $firstName, $generated_string) {

			$to = $email;

			try {
				$this->mail->IsSMTP(); 
				$this->mail->Username           = "hello@connectd.io"; 
				$this->mail->Password           = "kerching27"; 
				$this->mail->SMTPAuth           = true;            
				$this->mail->SMTPSecure         = "tls"; 
				$this->mail->Host               = "smtp.gmail.com";  
				$this->mail->Port               = 587; 
				$this->mail->addAddress($to);  

				$this->mail->From               = 'hello@connectd.io';
				$this->mail->FromName           = 'Connectd.io';
				$this->mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$this->mail->isHTML(true); 

				$this->mail->Subject            = 'Recover password -  Connectd.io';

				$this->mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$this->mail->Body              .= "<p>Please click the link below to reset your password:</p>";
				$this->mail->Body              .= "<p>" . BASE_URL . "recover.php?email=" . $email . "&generated_string=" . $generated_string . "</p>";
				$this->mail->Body              .= "<p>We will generate a new password for you and send it back to your email.</p>";
				$this->mail->Body              .= "<p>-- Connectd team</p>";
				$this->mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$this->mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$this->mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}
	    }

		public function sendNewPasswordEmail($email, $firstName, $generated_password) {
	
			$to = $email;

			try {
				$this->mail->IsSMTP(); 
				$this->mail->Username           = "hello@connectd.io"; 
				$this->mail->Password           = "kerching27"; 
				$this->mail->SMTPAuth           = true;            
				$this->mail->SMTPSecure         = "tls"; 
				$this->mail->Host               = "smtp.gmail.com";  
				$this->mail->Port               = 587; 
				$this->mail->addAddress($to);  

				$this->mail->From               = 'hello@connectd.io';
				$this->mail->FromName           = 'Connectd.io';
				$this->mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$this->mail->isHTML(true); 

				$this->mail->Subject            = 'Recover password -  Connectd.io';

				$this->mail->Body               = "<p>Hey " . $firstName . "!</p>";
				$this->mail->Body              .= "<p>Your your new password is: <b>" . $generated_password . "</b></p>";
				$this->mail->Body              .= "<p>Please change your password once you have logged in using this password.</p>";
				$this->mail->Body              .= "<p>-- Connectd team</p>";
				$this->mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$this->mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";

				$this->mail->Send();

			}catch(phpmailerException $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}catch(Exception $e) {
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
			}
	    }

		// public function sendEmail($to, $subject, $message, $mail) {

		// 	$to = $email;

		// 	try {
		// 		$this->mail->IsSMTP(); 
		// 		$this->mail->Username           = "hello@connectd.io"; 
		// 		$this->mail->Password           = "kerching27"; 
		// 		$this->mail->SMTPAuth           = true;            
		// 		$this->mail->SMTPSecure         = "tls"; 
		// 		$this->mail->Host               = "smtp.gmail.com";  
		// 		$this->mail->Port               = 587; 
		// 		$this->mail->addAddress($to);  

		// 		$this->mail->From               = 'hello@connectd.io';
		// 		$this->mail->FromName           = 'Connectd.io';
		// 		$this->mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
		// 		$this->mail->isHTML(true); 

		// 		$this->mail->MsgHTML($message);

		// 		$this->mail->Subject = $subject;

		// 		$this->mail->Send();

		// 	}catch(phpmailerException $e) {
		// 		$general = new General();
		// 		$general->errorView($general, $e);
		// 	}catch(Exception $e) {
		// 		$general = new General();
		// 		$general->errorView($general, $e);
		// 	}
	 //    }

	 //    public function sendConfirmationEmail($arg1, $arg2, $arg3) {
	 //    	$message = file_get_contents('email_templates/register.html');
	 //    	$this->sendEmail($subject, $message);
	 //    }

	}