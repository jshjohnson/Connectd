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

		public function sendEmail($email, $subject, $body) {

			try {
				$this->mail->IsSMTP(); 
				$this->mail->Username           = "hello@connectd.io"; 
				$this->mail->Password           = "kerching27"; 
				$this->mail->SMTPAuth           = true;            
				$this->mail->SMTPSecure         = "tls"; 
				$this->mail->Host               = "smtp.gmail.com";  
				$this->mail->Port               = 587; 
				$this->mail->addAddress($email);  

				$this->mail->From               = 'hello@connectd.io';
				$this->mail->FromName           = 'Connectd.io';
				$this->mail->AddReplyTo( 'hello@connectd.io', 'Contact Connectd.io' );
				
				$this->mail->isHTML(true); 

				$this->mail->MsgHTML($body);

				$this->mail->Subject = $subject;

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
	    	try {
		    	$subject = "You just got a vote on Connectd Trials!";
		    	$body = file_get_contents(BASE_URL . 'assets/email-templates/vote-added.php');
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{votes}}', $votes['CountOfvote_id'], $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
	    	}
	    }

		public function sendRecoverPasswordEmail($firstName, $email, $generatedString) {
			try {
		    	$subject = "Reset password -  Connectd.io";
		    	$body = file_get_contents(BASE_URL . 'assets/email-templates/reset-password.php');
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{email}}', $email, $body);
		    	$body = str_replace('{{string}}', $generatedString, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
	    	}	
	    }


	    public function sendNewPasswordEmail($firstName, $email, $generatedPassword) {
			try {
		    	$subject = "Your new password -  Connectd.io";
		    	$body = file_get_contents(BASE_URL . 'assets/email-templates/new-password.php');
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{newpassword}}', $generatedPassword, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
	    	}

	    }

		public function sendConfirmationEmail($firstName, $email, $emailCode) {
			try {
		    	$subject = "Activate your new Connectd account -  Connectd.io";
		    	$body = file_get_contents(BASE_URL . 'assets/email-templates/confirmation.php');
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{email}}', $email, $body);
		    	$body = str_replace('{{code}}', $emailCode, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
	    	}
	    }

	    public function sendMessageEmail($firstName, $email, $message, $sentBy) {
			try {
		    	$subject = "You just got a message - Connectd.io";
		    	$body = file_get_contents(BASE_URL . 'assets/email-templates/message.php');
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{sentBy}}', $sentBy, $body);
		    	$body = str_replace('{{message}}', $message, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$general = new General();
				$general->errorView($users, $general, $e);
	    	}
	    }
	}