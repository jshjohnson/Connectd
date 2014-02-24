<?php 
	class Designers {

		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}

		// Register a designer on sign up
		public function registerDesigner($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $age, $priceperhour, $experience, $bio){
			
			global $bcrypt; // making the $bcrypt variable global so we can use here
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);// generating a hash using the $bcrypt object
		 
			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".designers
				(firstname, lastname, email, email_code, time, password, location, portfolio, jobtitle, age, priceperhour, experience, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				");
		 
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $time);
			$query->bindValue(6, $password);
			$query->bindValue(7, $location);
			$query->bindValue(8, $portfolio);
			$query->bindValue(9, $jobtitle);
			$query->bindValue(10, $age);
			$query->bindValue(11, $priceperhour);
			$query->bindValue(12, $experience);
			$query->bindValue(13, $bio);
			$query->bindValue(14, $ip);
			
		 
			try{
				$query->execute();
		 
				$to = $email;

				$subject = 'Activate your new Connectd Account';

				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				$message = "<html><body>";
				$message .= "<p>Hey " . $firstname . "!</p>";
				$message .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				$message .= "<p>" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "&user=designer</p>";
				$message .= "<p>-- Connectd team</p>";
				$message .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$message .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";
				$message .= "</body></html>";

				mail($to, $subject, $message, $headers);
							
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}


		public function activateDesigner($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `designers` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `designers` SET `confirmed` = ? WHERE `email` = ?");
	 
					$query_2->bindValue(1, 1);
					$query_2->bindValue(2, $email);							
	 
					$query_2->execute();
					return true;
				} else {
					return false;
				}
	 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}