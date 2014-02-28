<?php
	class Users {
	 
		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		// Test if email already exists in database
		public function emailExists($email) {
		 
			$query = $this->db->prepare("SELECT `email`
						FROM " . DB_NAME . ".users
						WHERE `email` = ? 
					");
			$query->bindParam(1, $email);

			try{
		 
				$query->execute();
				$rows = $query->rowCount();
		 
				if($rows > 0){
					return true;
				}else{
					return false;
				}
		 
			} catch (PDOException $e){
				die($e->getMessage());
			}
		 
		}

		// Test if user has confirmed their email
		public function emailConfirmed($email) {
 
			$query = $this->db->prepare("SELECT COUNT(*) FROM (
				(SELECT 1 FROM " . DB_NAME . ".users AS a WHERE a.email = ? AND a.confirmed = ?)) z
			");

			$query->bindValue(1, $email);
			$query->bindValue(2, 1);
			
			try{
				
				$query->execute();
				$rows = $query->fetchColumn();
		 
				if($rows == 1){
					return true;
				}else{
					return false;
				}
		 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function login($email, $password) {

			global $bcrypt;  // Make the bcrypt variable global, which is defined in init.php, which is included in login.php where this function is called
 
			$query = $this->db->prepare("SELECT 
					`id`, `email`, `password`
					FROM " . DB_NAME . ".users
					WHERE `email` = ? 
				");
			$query->bindValue(1, $email);
			
			try{
				
				$query->execute();
				$data 				= $query->fetch();
				$stored_password 	= $data['password'];
				$id 				= $data['id'];
				
				// hashing the supplied password and comparing it with the stored hashed password.
				if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
					return $id;	
				}else{
					return false;	
				}
		 
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function getTrialUsers() {
 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT 
				`firstname`, `lastname`, `jobtitle`, `location`, `portfolio`, `experience`, `votes`, `time`
				FROM designers WHERE `confirmed` = ?
				UNION SELECT 
				`firstname`, `lastname`, `jobtitle`, `location`, `portfolio`, `experience`, `votes`, `time`
				FROM developers WHERE `confirmed` = ?");

			$query->bindValue(1, 0);
			$query->bindValue(2, 0);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		// Get user data
		public function userData($id) {
 
			$query = $this->db->prepare("
				SELECT firstname, lastname, user_type FROM " . DB_NAME . ".users WHERE `id`= ?
				");
			// UNION SELECT firstname, lastname FROM " . DB_NAME . ".designers WHERE `id`= ?
			// UNION SELECT firstname, lastname FROM " . DB_NAME . ".employers WHERE `id`= ?
			$query->bindValue(1, $id);
			// $query->bindValue(2, $id);
			// $query->bindValue(3, $id);
		 
			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}
		
		public function activateUser($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");
	 
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