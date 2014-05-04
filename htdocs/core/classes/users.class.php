<?php
	class Users {
	 
	 	// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		    $this->bcrypt = new Bcrypt(12);
		    $this->emails = new Emails();
		}
	  
		/**
		 * Test if email already exists in database
		 *
		 * @param  string  $email The email of the user
		 * @return boolean
		 */ 
		public function emailExists($email) {
		 
			$query = $this->db->prepare("
				SELECT `email`
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
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		/**
		 *  Logs in user
		 *
		 * @param  string  $email The users email address
		 * @param  string  $password The users password
		 * @return boolean
		 */ 
		public function doLogin($email, $password) {
 
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
				if($this->bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
					return $id;	
				}else{
					return false;	
				}
		 
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

	 	/**
		 * Performs user log out
		 *
		 * @param  void
		 * @return void
		 */ 
	    public function doLogout() {
			// Unset all of the session variables.
			$_SESSION = array();
			// Destroy the session
			session_destroy();
			header('Location: ' . BASE_URL . 'login/logged-out/');
	    }

	 	/**
		 * Test if user is logged in
		 *
		 * @param  void
		 * @return boolean
		 */ 
		public function loggedIn() {
			return(isset($_SESSION['user_id'])) ? true : false;
		}
	 
	 	/**
		 * If used is logged in, redirect them appropriately
		 *
		 * @param  void
		 * @return void
		 */ 
		public function loggedInProtect() {
			if ($this->loggedIn() === true) {
				header("Location:" . BASE_URL . "dashboard/");
				exit();		
			}
		}
		
	 	/**
		 * Check if user is logged out, if so direct them to the homepage
		 *
		 * @param  void
		 * @return boolean
		 */ 
		public function loggedOutProtect() {
			if ($this->loggedIn() === false) {
				header("Location:" . BASE_URL);
				exit();
			}	
		}

		public function grantedAccessProtect($id) {
			$access = $this->fetchInfo("granted_access", "user_id", $id);

			if($access == 0) {
				header("Location:" . BASE_URL . "welcome/");
				exit();
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
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
			$query = $this->db->prepare("
				SELECT `town` 
				FROM " . DB_NAME . ".locations 
				ORDER BY `town` ASC");
			try{
				$query->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
				SELECT users.user_id, users.firstname, users.lastname, users.email, users.password, users.bio, users.image_location, users.portfolio, user_types.*
				FROM " . DB_NAME . ".users 
				JOIN " . DB_NAME . ".user_types 
				ON 
					users.user_id = user_types.user_type_id
				WHERE 
					users.user_id= ?
			");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		/**
		 *  Gets key user data of user logged in
		 *
		 * @param  int  $id The user logged in's ID
		 * @return array
		 */ 
		public function userType($id) {
			$query = $this->db->prepare("
				SELECT users.user_id, user_types.*
				FROM " . DB_NAME . ".users 
				JOIN " . DB_NAME . ".user_types 
				ON 
					users.user_id = user_types.user_type_id
				WHERE 
					users.user_id= ?
			");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
		
			$query = $this->db->prepare("
				SELECT COUNT(`user_id`) 
				FROM `users` 
				WHERE 
					`email` = ? 
				AND `email_code` = ? 
				AND `confirmed` = ?
			");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("
						UPDATE " . DB_NAME . ".users 
						SET 
							`confirmed` = ?,
							`granted_access` = ?
						WHERE 
							`email` = ?
					");
	 
					$query_2->bindValue(1, 1);
					$query_2->bindValue(2, 1);
					$query_2->bindValue(3, $email);							
	 
					$query_2->execute();
					return true;
				} else {
					return false;
				}
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		/**
		 *  Delete user
		 *
		 * @param  string  $userID The ID of the user
		 * @return array
		 */ 
		public function deleteUser($userID) {
		
			$query = $this->db->prepare("
				DELETE FROM " . DB_NAME . ".users
				WHERE user_id = :user_id
			");
	 
			$query->bindValue(":user_id", $userID);
	 
			try{
				$query->execute();
				$this->doLogout();
				header('Location: ' . BASE_URL);
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		public function fetchInfo($what, $field, $value, $table = "users"){
		 
			$allowed = array('user_id', 'email', 'firstname', 'lastname', 'bio', 'granted_access', 'employer_name', 'employer_id', 'email_code');
			if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
			    throw new InvalidArgumentException;
			}else{
			
				$query = $this->db->prepare("
					SELECT $what 
					FROM " . DB_NAME . ".$table
					WHERE 
						$field = ?
				");
		 
				$query->bindValue(1, $value);
		 
				try{
					$query->execute();
				}catch(PDOException $e) {
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
				}
		 
				return $query->fetchColumn();
			}
		}
		 
		 
		public function confirmRecover($email){
		 
			$firstName = $this->fetchInfo('firstname', 'email', $email); // We want the 'firstname' WHERE 'email' = user's email ($email)
		 
			$unique = uniqid('',true); // generate a unique string
			$random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10); // generate a more random string
			
			$generatedString = $unique . $random; // a random and unique string
		 
			$query = $this->db->prepare("
				UPDATE " . DB_NAME . ".users 
				SET 
					`generated_string` = ? 
				WHERE 
					`email` = ?
			");
		 
			$query->bindValue(1, $generatedString);
			$query->bindValue(2, $email);
		 
			try{	
				$query->execute();
				$this->emails->sendRecoverPasswordEmail($firstName, $email, $generatedString);
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		public function recover($email, $generatedString) {
		 
			if($generatedString == 0){
				return false;
			}else{
		 
				$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `generated_string` = ?");
		 
				$query->bindValue(1, $email);
				$query->bindValue(2, $generatedString);
		 
				try{
		 
					$query->execute();
					$rows = $query->fetchColumn();
		 
					if($rows == 1){ // if we find email/generated_string combo
		 
						$firstName = $this->fetchInfo('firstname', 'email', $email); // getting username for the use in the email.
						$userID  = $this->fetchInfo('user_id', 'email', $email);// We want to keep things standard and use the user's id for most of the operations. Therefore, we use id instead of email.

						$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
						$generatedPassword = substr(str_shuffle($charset),0, 10);

						$this->changePassword($userID, $generatedPassword); // change the password.
		 
						$query = $this->db->prepare("
							UPDATE `users` 
							SET 
								`generated_string` = 0 
							WHERE 
								`user_id` = ?
						"); // set generated_string back to 0
		 
						$query->bindValue(1, $userID);
		 				
	 					try{	
							$query->execute();
							$this->emails->sendNewPasswordEmail($firstName, $email, $generatedPassword);
						}catch(PDOException $e) {
							$users = new Users($db);
							$debug = new Errors();
							$debug->errorView($users, $e);	
						}

					}else{
						return false;
					}
				}catch(PDOException $e) {
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
				}
			}
		}
		 
		public function changePassword($userID, $password) {
		 
			$passwordHash = $this->bcrypt->genHash($password);
		 
			$query = $this->db->prepare("
				UPDATE " . DB_NAME . ".users 
				SET 
					`password` = ? 
				WHERE 
					`user_id` = ?
			");
		 
			$query->bindValue(1, $passwordHash);
			$query->bindValue(2, $userID);				
		 
			try{
				$query->execute();
				return true;
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		public function updateUser($firstName, $lastName, $portfolio, $email, $bio, $imageLocation, $sessionUserID) {
 
			$query = $this->db->prepare("
				UPDATE " . DB_NAME . ".users
				SET	`firstname`= :firstname,
					`lastname` = :lastname,
					`email` = :email,
					`portfolio` = :portfolio,
					`bio` = :bio,
					`image_location` = :image_location
				WHERE 
					`user_id` = :user_id
			");
			$query->bindValue(":firstname", $firstName);
			$query->bindValue(":lastname", $lastName);
			$query->bindValue(":email", $email);
			$query->bindValue(":portfolio", $portfolio);
			$query->bindValue(":bio", $bio);
			$query->bindValue(":image_location", $imageLocation);
			$query->bindValue(":user_id", $sessionUserID);
			
			try{
				$query->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		public function updateTestimonial($testimonial, $testimonialSource, $sessionUserID) {

			$testimonialQuery = $this->db->prepare("
				INSERT INTO " . DB_NAME . ".freelancer_testimonials
					(testimonial_id, testimonial, testimonial_source)
				VALUES 
					(:userID, :testimonial, :testimonialSource)
				ON DUPLICATE KEY 
				UPDATE
					`testimonial` = :testimonial,
					`testimonial_source` = :testimonialSource 
			");

			$testimonialQuery->bindValue(":userID", $sessionUserID);
			$testimonialQuery->bindValue(":testimonial", $testimonial);
			$testimonialQuery->bindValue(":testimonialSource", $testimonialSource);

			try{
				$testimonialQuery->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		public function removeSkills($sessionUserID) {
			$deleteQuery = $this->db->prepare("
				DELETE FROM " . DB_NAME . ".freelancer_skills
				WHERE 
					skill_id = :userID
			");

			$deleteQuery->bindValue(":userID", $sessionUserID);

			try{
				$deleteQuery->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
	
		}

		public function updateSkills($skill, $skillRating = NULL, $sessionUserID) {

			$insertQuery = $this->db->prepare("
				INSERT INTO " . DB_NAME . ".freelancer_skills
					(skill_id, skill, skill_rating)
				VALUES 
					(:userID, :skill, :skillRating)
			");

			$insertQuery->bindValue(":skill", $skill);
			$insertQuery->bindValue(":skillRating", $skillRating);
			$insertQuery->bindValue(":userID", $sessionUserID);

			try{
				$insertQuery->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}
	}