<?php 
	class Emails {

		public function __construct() {
		    $this->mail = new PHPMailer();
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

	    public function sendMessageEmail($firstName, $email, $message, $sentBy) {
			try {
		    	$subject = "You just got a message - Connectd.io";
		    	$body = file_get_contents(ROOT_PATH . 'assets/email-templates/message.html');
		    	$body = str_replace('{{subject}}', $subject, $body);
		    	$body = str_replace('{{name}}', $firstName, $body);
		    	$body = str_replace('{{sentBy}}', $sentBy, $body);
		    	$body = str_replace('{{message}}', $message, $body);
		    	$body = str_replace('{{url}}', BASE_URL, $body);
		    	$this->sendEmail($email, $subject, $body);
	    	}catch(Exception $e){
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
	    	}
	    }

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