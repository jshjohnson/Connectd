<?php 
	class Emails {

		public function __construct() {
		    $this->mail = new PHPMailer();
		}


	 	/**
		 * Sends email using PHPMailer
		 *
		 * @param  $email - recipient's email
		 * @param  $subject
		 * @param  $body
		 * @return void
		 */ 
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
				$this->mail->isHTML(true); 
				$this->mail->MsgHTML($body);
				$this->mail->Subject = $subject;
				$this->mail->Send();
			}catch(phpmailerException $e) {
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
			}catch(Exception $e) {
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
			}
	    }

	 	/**
		 * Sends vote email
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @param  $votes - Number of votes recipient has
		 * @return void
		 */ 
	    public function sendVoteEmail($firstName, $email, $votes) {
	    	try {
		    	$subject = "You just got a vote on Connectd Trials!";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/vote-added.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{votes}}', $votes['CountOfvote_id'], $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
	    	}
	    }

	 	/**
		 * Sends star notification email
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @return void
		 */ 
	    public function sendStarEmail($firstName, $email) {
	    	try {
		    	$subject = "Someone just gave you a star on Connectd!";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/star-added.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
	    	}
	    }

	    /**
		 * Sends trial period ended email
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @return void
		 */ 
	    public function sendTrialEndedEmail($firstName, $email) {
	    	try {
		    	$subject = "Congratulations - You have been granted access to the Connectd Community.";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/trial-ended.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
	    	}
	    }

	 	/**
		 * Sends recover password to user email
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @param  $generatedString - created when user submits recover password request
		 * @return void
		 */ 
		public function sendRecoverPasswordEmail($firstName, $email, $generatedString) {
			try {
		    	$subject = "Reset password -  Connectd.io";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/reset-password.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{email}}', $email, $body);
		    	$body = str_replace('{{string}}', $generatedString, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
	    	}
	    }

	 	/**
		 * Sends new password email
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @param  $generatedPassword - New password generated on the fly
		 * @return void
		 */ 
	    public function sendNewPasswordEmail($firstName, $email, $generatedPassword) {
			try {
		    	$subject = "Your new password -  Connectd.io";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/new-password.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{newpassword}}', $generatedPassword, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
	    	}
	    }

	 	/**
		 * Sends confirmation email to new user - activate account
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @param  $emailCode - Created on sign up - must match DB
		 * @return void
		 */ 
		public function sendConfirmationEmail($firstName, $email, $emailCode) {
			try {
		    	$subject = "Activate your new Connectd account -  Connectd.io";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/confirmation.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{email}}', $email, $body);
		    	$body = str_replace('{{code}}', $emailCode, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
	    	}
	    }

	 	/**
		 * Sends message email
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @param  $message
		 * @param  $sentByName
		 * @param  $sentByEmail
		 * @param  $sentByProfile - URL of user sending message
		 * @return void
		 */ 
	    public function sendMessageEmail($firstName, $email, $message, $sentByName, $sentByEmail, $sentByProfile) {
			try {
		    	$subject = $sentByName . " just sent you a new message - Connectd.io";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/message.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{sentByName}}', $sentByName, $body);
		    	$body = str_replace('{{sentByEmail}}', $sentByEmail, $body);
		    	$body = str_replace('{{sentByProfile}}', $sentByProfile, $body);
		    	$body = str_replace('{{message}}', $message, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
	    	}
	    }

	 	/**
		 * Sends job application email
		 *
		 * @param  $firstName 
		 * @param  $email
		 * @param  $message
		 * @param  $sentByName
		 * @param  $sentByEmail
		 * @param  $sentByProfile - URL of user sending message
		 * @return void
		 */ 
	    public function sendJobApplicationEmail($firstName, $email, $message, $sentByName, $sentByEmail, $sentByProfile) {
			try {
		    	$subject = $sentByName . " just applied for your job post - Connectd.io";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/job-application.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{sentByName}}', $sentByName, $body);
		    	$body = str_replace('{{sentByEmail}}', $sentByEmail, $body);
		    	$body = str_replace('{{sentByProfile}}', $sentByProfile, $body);
		    	$body = str_replace('{{message}}', $message, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
	    	}
	    }

	 	/**
		 * Sends invite email
		 *
		 * @param  $email
		 * @return void
		 */ 
	    public function sendInviteEmail($email) {
			try {
		    	$subject = "You just got a message - Connectd.io";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/invite.html');
		    	$subject = "Connectd.io beta invite";
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
	    	}
	    }

	}