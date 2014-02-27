<?php
	class Users {
	 
		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		// Test if email already exists in database
		public function email_exists($email) {
		 
			$query = $this->db->prepare("SELECT designers.email 
						FROM " . DB_NAME . ".designers 
						WHERE designers.email = ? 
						UNION SELECT developers.email 
						FROM " . DB_NAME . ".developers 
						WHERE developers.email = ?
						UNION SELECT employers.email 
						FROM " . DB_NAME . ".employers 
						WHERE employers.email = ?");
			$query->bindParam(1, $email);
			$query->bindParam(2, $email);
			$query->bindParam(3, $email);

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
		public function email_confirmed($email) {
 
			$query = $this->db->prepare("SELECT COUNT(*) FROM (
				(SELECT 1 FROM " . DB_NAME . ".developers AS a WHERE a.email = ? AND a.confirmed = ?)
				UNION ALL 
				(SELECT 1 FROM " . DB_NAME . ".designers AS b WHERE b.email = ? AND b.confirmed = ?) 
				UNION ALL
				(SELECT 1 FROM " . DB_NAME . ".employers AS c WHERE c.email = ? AND c.confirmed = ?)) z
			");

			$query->bindValue(1, $email);
			$query->bindValue(2, 1);
			$query->bindValue(3, $email);
			$query->bindValue(4, 1);
			$query->bindValue(5, $email);
			$query->bindValue(6, 1);
			
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
				designers.id, designers.email, designers.password 
				FROM " . DB_NAME . ".designers 
				WHERE designers.email = ? 
				UNION SELECT developers.id, developers.email, developers.password 
				FROM " . DB_NAME . ".developers WHERE developers.email = ? 
				UNION SELECT employers.id, employers.email, employers.password 
				FROM " . DB_NAME . ".employers WHERE employers.email = ?");
			$query->bindValue(1, $email);
			$query->bindValue(2, $email);
			$query->bindValue(3, $email);
			
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

		public function get_trial_users() {
 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT 
				firstname, lastname, jobtitle, location, portfolio, experience, votes, time
				FROM designers 
				UNION SELECT 
				firstname, lastname, jobtitle, location, portfolio, experience, votes, time
				FROM developers");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		// Get user data
		public function userdata($id) {
 
			$query = $this->db->prepare("
				SELECT firstname, lastname FROM " . DB_NAME . ".developers WHERE `id`= ?
				UNION SELECT firstname, lastname FROM " . DB_NAME . ".designers WHERE `id`= ?
				UNION SELECT firstname, lastname FROM " . DB_NAME . ".employers WHERE `id`= ?
				");
			$query->bindValue(1, $id);
			$query->bindValue(2, $id);
			$query->bindValue(3, $id);
		 
			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}

		// Get any field in a users table, by supplying any other field for a user
		public function fetch_info($what, $field, $value){
 
			$allowed = array('id', 'email', 'first_name', 'last_name'); // Do not add 'password' even though the parameters will only be given by you and not the user, in the system.
			if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
			    throw new InvalidArgumentException;
			}else{
			
				$query = $this->db->prepare("SELECT $what FROM `developers` WHERE $field = ?");
		 
				$query->bindValue(1, $value);
		 
				try{
		 
					$query->execute();
					
				} catch(PDOException $e){
		 
					die($e->getMessage());
				}
		 
				return $query->fetchColumn();
			}
		}
		 
		// Confirm recovery by sending email to user with generated string in URL
		public function confirm_recover($email){
		 
			$username = $this->fetch_info('email', $email);// We want the 'username' WHERE 'email' = user's email ($email)
		 
			$unique = uniqid('',true); // generate a unique string
			$random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10); // generate a more random string
			
			$generated_string = $unique . $random; // a random and unique string
		 
			$query = $this->db->prepare("UPDATE `developers` SET `generated_string` = ? WHERE `email` = ?");
		 
			$query->bindValue(1, $generated_string);
			$query->bindValue(2, $email);
		 
			try{
				
				$query->execute();
		 
				mail($email, 'Recover Password', "Hello " . $username. ",\r\nPlease click the link below:\r\n\r\n" . BASE_URL . "recover.php?email=" . $email . "&generated_string=" . $generated_string . "\r\n\r\n We will generate a new password for you and send it back to your email.\r\n\r\n-- Connectd team");			
				
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		// Actually recover password
		public function recover($email, $generated_string) {
 
			// Test if there is in fact a generated string
			if($generated_string == 0){
				return false;
			}else{
		 
				$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email` = ? AND `generated_string` = ?");
		 
				$query->bindValue(1, $email);
				$query->bindValue(2, $generated_string);
		 
				try{
		 
					$query->execute();
					$rows = $query->fetchColumn();
		 
					if($rows == 1){ // if we find email/generated_string combo
						
						global $bcrypt;
		 
						$username = $this->fetch_info('username', 'email', $email); // getting username for the use in the email.
						$user_id  = $this->fetch_info('id', 'email', $email);// We want to keep things standard and use the user's id for most of the operations. Therefore, we use id instead of email.
				
						$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
						$generated_password = substr(str_shuffle($charset),0, 10);
		 
						$this->change_password($user_id, $generated_password); // change the password.
		 
						$query = $this->db->prepare("UPDATE `users` SET `generated_string` = 0 WHERE `id` = ?");// set generated_string back to 0
		 
						$query->bindValue(1, $user_id);
		 
						$query->execute();
		 
						#mail the user the new password.
						mail($email, 'Your password', "Hello " . $username . ",\n\nYour your new password is: " . $generated_password . "\n\nPlease change your password once you have logged in using this password.\n\n-Example team"); 
		 
					}else{
						return false;
					}
		 
				} catch(PDOException $e){
					die($e->getMessage());
				}
			}
		}

		// Finally change the password and then crypting it 
		public function change_password($user_id, $password) {
		 
			global $bcrypt;
		 
			/* Two create a Hash you do */
			$password_hash = $bcrypt->genHash($password);
		 
			$query = $this->db->prepare("UPDATE `developers` SET `password` = ? WHERE `id` = ?");
		 
			$query->bindValue(1, $password_hash);
			$query->bindValue(2, $user_id);				
		 
			try{
				$query->execute();
				return true;
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		// Test whether user is a designer, developer or employer
		public function test_user() {

		}

	}