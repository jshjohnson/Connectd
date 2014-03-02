<?php 
	class Employers {

		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}

		// Register en employer on sign up
		public function registerEmployer($firstname, $lastname, $email, $password, $businessname, $location, $businesstype, $businesswebsite, $businessbio, $user_type){

			global $bcrypt; // making the $bcrypt variable global so we can use here
			global $mail;
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);// generating a hash using the $bcrypt object

			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, time, password, ip, user_type) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $time);
			$query->bindValue(6, $password);
			$query->bindValue(7, $ip);
			$query->bindValue(8, $user_type);
			
		 
			try{
				$query->execute();
		 
				$to = $email;

				$mail->Host = "localhost";  // specify main and backup server
				$mail->Username = "josh@joshuajohnson.co.uk";  // SMTP username
				$mail->Password = "cheeseball27"; // SMTP password
				$mail->SMTPAuth = true;     // turn on SMTP authentication
				$mail->addAddress($to);  // Add a recipient=
                
                $mail->From = 'noreply@connectd.io';
				$mail->FromName = 'Connectd.io';
                // Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject = 'Activate your new Connectd account';

				$mail->Body = "<p>Hey " . $firstname . "!</p>";
				$mail->Body .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				$mail->Body .= "<p>" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "</p>";
				$mail->Body .= "<p>-- Connectd team</p>";
				$mail->Body .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
				   echo 'Message could not be sent.';
				   echo 'Mailer Error: ' . $mail->ErrorInfo;
				   exit;
				}
							
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
	}