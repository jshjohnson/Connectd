<?php 
	class Developers {

		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
		
		// Register a developer on sign up
		public function registerDeveloper($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $age, $priceperhour, $experience, $bio){
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password = sha1($password);
		 
			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".developers
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
		 
				mail($email, 'Please activate your account', "Hello " . $firstname. ",\r\n\r\nThank you for registering with Connectd. Please visit the link below so we can activate your account:\r\n\r\n" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "&user=developer\r\n\r\n-- Connectd team");
			
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		
		public function activateDeveloper($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `developers` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `developers` SET `confirmed` = ? WHERE `email` = ?");
	 
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