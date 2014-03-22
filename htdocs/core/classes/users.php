<?php
	class Users {
	 
	 	// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		/**
		 * Tests if email already exists in database
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
		 
			} catch (PDOException $e){
				die($e->getMessage());
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
		 
			} catch(PDOException $e){
				die($e->getMessage());
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
				$data 				= $query->fetch();
				$stored_password 	= $data['password'];
				$id 				= $data['user_id'];
				
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
			}catch(PDOException $e){
				die($e->getMessage());
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
			$query = $this->db->prepare("SELECT town FROM " . DB_NAME . ".towns ORDER BY town ASC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
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
				SELECT users.firstname, users.lastname, users.email, user_types.*
				FROM " . DB_NAME . ".users 
				JOIN " . DB_NAME . ".user_types 
				ON users.user_id = user_types.user_type_id
				WHERE users.user_id= ?
				");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
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
	 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}