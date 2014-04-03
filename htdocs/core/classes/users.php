<?php
	class Users {
	 
	 	// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		/**
		 * Test if email already exists in database
		 *
		 * @param  string  $email The email of the user
		 * @return boolean
		 */ 
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
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
		 
		}

		/**
		 *  Tests whether a user has confirmed their email
		 *
		 * @param  string  $email The email of the user
		 * @return boolean
		 */ 
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
		 
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
		}

		/**
		 *  Logs in user
		 *
		 * @param  string  $email The users email address
		 * @param  string  $password The users password
		 * @return boolean
		 */ 
		public function login($email, $password) {

			global $bcrypt;  // Make the bcrypt variable global, which is defined in init.php, which is included in login.php where this function is called
 
			$query = $this->db->prepare("SELECT 
					`user_id`, `email`, `password`
					FROM " . DB_NAME . ".users
					WHERE `email` = ? 
				");
			$query->bindValue(1, $email);
			
			try{
				
				$query->execute();
				$data = $query->fetch();
				$stored_password = $data['password'];
				$id = $data['user_id'];
				
				// hashing the supplied password and comparing it with the stored hashed password.
				if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
					return $id;	
				}else{
					return false;	
				}
		 
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
		}

		/**
		 *  Gets user experience form values
		 *
		 * @param  void
		 * @return array
		 */ 
		 public function getExperiences() {
	    	$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".user_experience LIKE 'experience'");
			try{
				$query->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			preg_match_all("/'(.*?)'/", $row['Type'], $categories);
			$fields = $categories[1];
			return $fields;
	    }

		/**
		 *  Gets user location form values
		 *
		 * @param  void
		 * @return array
		 */ 
	    public function getLocations() {
			$query = $this->db->prepare("SELECT town FROM " . DB_NAME . ".locations ORDER BY town ASC");
			try{
				$query->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	    }

		/**
		 *  Gets key user data of user logged in
		 *
		 * @param  int  $id The user logged in's ID
		 * @return array
		 */ 
		public function userData($id) {
			$query = $this->db->prepare("
				SELECT users.user_id, users.firstname, users.lastname, users.email, users.password, users.bio, users.image_location, user_types.*
				FROM " . DB_NAME . ".users 
				JOIN " . DB_NAME . ".user_types 
				ON users.user_id = user_types.user_type_id
				WHERE users.user_id= ?
				");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
		}
		
		/**
		 *  Activates user
		 *
		 * @param  string  $email The users email address
		 * @param  string  $email_code Generated string created on sign up
		 * @return array
		 */ 
		public function activateUser($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
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
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
		}

		public function fetchInfo($what, $field, $value){
		 
			$allowed = array('user_id', 'email', 'firstname', 'lastname', 'bio'); // I have only added few, but you can add more. However do not add 'password' even though the parameters will only be given by you and not the user, in our system.
			if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
			    throw new InvalidArgumentException;
			}else{
			
				$query = $this->db->prepare("SELECT $what FROM `users` WHERE $field = ?");
		 
				$query->bindValue(1, $value);
		 
				try{
		 
					$query->execute();
					
				}catch(PDOException $e) {
					$general = new General($db);
					$general->errorView($general, $e);
				}
		 
				return $query->fetchColumn();
			}
		}
		 
		 
		public function confirmRecover($email){

			global $general;
		 
			$firstName = $this->fetchInfo('firstname', 'email', $email); // We want the 'username' WHERE 'email' = user's email ($email)
		 
			$unique = uniqid('',true); // generate a unique string
			$random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10); // generate a more random string
			
			$generated_string = $unique . $random; // a random and unique string
		 
			$query = $this->db->prepare("UPDATE `users` SET `generated_string` = ? WHERE `email` = ?");
		 
			$query->bindValue(1, $generated_string);
			$query->bindValue(2, $email);
		 
			try{
				
				$query->execute();

				$general->sendRecoverPasswordEmail($email, $firstName, $generated_string);
		 				
			} catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
		}

		public function recover($email, $generated_string) {

			global $general;
		 
			if($generated_string == 0){
				return false;
			}else{
		 
				$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `generated_string` = ?");
		 
				$query->bindValue(1, $email);
				$query->bindValue(2, $generated_string);
		 
				try{
		 
					$query->execute();
					$rows = $query->fetchColumn();
		 
					if($rows == 1){ // if we find email/generated_string combo
						
						global $bcrypt;
		 
						$firstName = $this->fetchInfo('firstname', 'email', $email); // getting username for the use in the email.
						$user_id  = $this->fetchInfo('user_id', 'email', $email);// We want to keep things standard and use the user's id for most of the operations. Therefore, we use id instead of email.
				
						$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
						$generated_password = substr(str_shuffle($charset),0, 10);
		 
						$this->changePassword($user_id, $generated_password); // change the password.
		 
						$query = $this->db->prepare("UPDATE `users` SET `generated_string` = 0 WHERE `user_id` = ?");// set generated_string back to 0
		 
						$query->bindValue(1, $user_id);
		 
						$query->execute();

		 				$general->sendNewPasswordEmail($email, $firstName, $generated_password);

					}else{
						return false;
					}
		 
				} catch(PDOException $e) {
					$general = new General($db);
					$general->errorView($general, $e);
				}
			}
		}
		 
		public function changePassword($user_id, $password) {
		 
			global $bcrypt;
		 
			/* Two create a Hash you do */
			$passwordHash = $bcrypt->genHash($password);
		 
			$query = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `user_id` = ?");
		 
			$query->bindValue(1, $passwordHash);
			$query->bindValue(2, $user_id);				
		 
			try{
				$query->execute();
				return true;
			} catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
		}

		public function updateUser($firstName, $lastName, $bio, $imageLocation, $user_id){
 
			$query = $this->db->prepare("UPDATE `users` SET
									`firstname`= ?,
									`lastname` = ?,
									`bio` = ?,
									`image_location`= ?	
									WHERE `user_id` 		= ? 
									");
		 
			$query->bindValue(1, $firstName);
			$query->bindValue(2, $lastName);
			$query->bindValue(3, $bio);
			$query->bindValue(4, $imageLocation);
			$query->bindValue(5, $user_id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
	}