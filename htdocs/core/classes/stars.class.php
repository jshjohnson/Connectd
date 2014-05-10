<?php
	class Stars {
	 
		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		    $this->emails = new Emails();
		}


		/**
		 * Gets the avatar of starred_by_id where starred_by_id has voted for user_id
		 *
		 * @param  integer  $id The user to test
		 * @return array
		 */ 

		public function getUserStars($id) {
			$query = $this->db->prepare("
				SELECT users.user_id, users.image_location, user_stars.starred_by_id, user_types.user_type
				FROM " . DB_NAME . ".users
				LEFT JOIN " . DB_NAME . ".user_stars
				ON 
					user_stars.starred_by_id = users.user_id 
				LEFT JOIN " . DB_NAME . ".user_types
				ON 
					user_types.user_type_id = user_stars.starred_by_id
				WHERE 
					user_stars.star_id = :id
				AND
					user_types.user_type != :userType
				AND
					users.granted_access = :grantedAccess	
			");
			$query->bindValue(":id", $id);
			$query->bindValue(":userType", "employer");
			$query->bindValue(":grantedAccess", 1);

			try{
				$query->execute();
				# We use fetchAll() instead of fetch() to get an array of all the selected records.
				return $query->fetchAll();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		/**
		 * Adds a star to the database
		 *
		 * @param  integer  $user_id The user recieving a star
		 * @param  integer  $starredBy The user logged in voting
		 * @return void
		 */ 
		public function addstar($user_id, $starredBy) {

			$query = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_stars (star_id, starred_by_id) VALUES (?, ?)");

			$query->bindValue(1, $user_id);
			$query->bindValue(2, $starredBy);
			
			$this->db->beginTransaction();

			try{
				$query->execute();

				$getUserInfo = $this->db->prepare("SELECT u.firstname, u.email, u.user_id FROM " . DB_NAME . ".users AS u WHERE u.user_id = ?");
				$getUserInfo->bindValue(1, $user_id);
				$getUserInfo->execute();
				$to = $getUserInfo->fetch();

				$firstName = $to['firstname'];
				$email = $to['email'];

				$this->emails->sendStarEmail($firstName, $email);

				$this->db->commit();

				header('Location: ' . $_SERVER['HTTP_REFERER']);

			}catch(PDOException $e) {
				$this->db->rollback();
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
	    }

	    /**
		 * Removes a star from the database
		 *
		 * @param  integer  $user_id The user who recieved a star
		 * @param  integer  $starredBy The user logged in voting
		 * @return void
		 */ 
	    public function removeStar($user_id, $starredBy) {
			$query = $this->db->prepare("DELETE FROM " . DB_NAME . ".user_stars WHERE user_stars.star_id = ? AND user_stars.starred_by_id = ?");

			$query->bindValue(1, $user_id);
			$query->bindValue(2, $starredBy);
			
			try{
				$query->execute();
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
	    }

		/**
		 * Tests whether the user logged in has starred for another user
		 *
		 * @param  integer  $star_id The user getting a star
		 * @param  integer  $starredBy The user logged in voting
		 * @return boolean
		 */ 
	    public function sessionUserStarred($user_id, $starredBy) {
	    	$query = $this->db->prepare("
	    		SELECT us.star_id, us.starred_by_id 
	    		FROM " . DB_NAME . ".user_stars AS us
	    		WHERE us.star_id = ?
	    		AND us.starred_by_id = ?
	    	");

	    	$query->bindValue(1, $user_id);
	    	$query->bindValue(2, $starredBy);

			try{
				$query->execute();
				$rows = $query->rowCount();

				// If there are over 0 rows returned, the user has starred
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

		public function getStarredFreelancers($starredBy) {
			$query = $this->db->prepare("
				SELECT 
				user_types.user_type,
				users.user_id, users.confirmed, users.firstname, users.lastname, users.location, users.image_location, 
				freelancers.jobtitle, freelancers.priceperhour, user_stars.star_id, user_stars.starred_by_id
				FROM " . DB_NAME . ".users AS starredUsers
				RIGHT JOIN 
				(((users LEFT JOIN user_stars 
				ON users.user_id = user_stars.star_id) 
					LEFT JOIN freelancers 
				ON users.user_id = freelancers.freelancer_id) 
					LEFT JOIN user_types
				ON users.user_id = user_types.user_type_id) 
				ON users.user_id = user_stars.star_id
				WHERE 
					user_types.user_type != :user_type
				AND 
					users.confirmed = :confirmed
				AND 
					user_stars.starred_by_id = :starred_by
				AND 
					users.user_id != :starred_by
				AND
					users.granted_access = :grantedAccess
				GROUP BY
				users.user_id,
				users.firstname, 
				users.lastname, 
				user_stars.star_id,
				freelancers.jobtitle, 
				freelancers.priceperhour
			");
			$query->bindValue(":user_type", 'employer');
			$query->bindValue(":confirmed", 1);
			$query->bindValue(":starred_by", $starredBy);
			$query->bindValue(":grantedAccess", 1);

			try{
				$query->execute();
				# We use fetchAll() instead of fetch() to get an array of all the selected records.
				return $query->fetchAll();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		public function getStarredEmployers($starredBy) {
			$query = $this->db->prepare("
				SELECT 
				user_types.user_type,
				users.user_id, users.confirmed, users.firstname, users.lastname, users.location, users.image_location, 
				employers.employer_name, employer_types.employer_type, COUNT(DISTINCT jobs.job_id) AS job_count, user_stars.star_id, user_stars.starred_by_id
				FROM " . DB_NAME . ".users AS starredUsers
				RIGHT JOIN 
				(((((users LEFT JOIN " . DB_NAME . ".user_stars 
					ON users.user_id = user_stars.star_id) 
						LEFT JOIN " . DB_NAME . ".employers 
					ON users.user_id = employers.employer_id)
						LEFT JOIN " . DB_NAME . ".employer_types
					ON users.user_id = employer_types.employer_type_id)
						LEFT JOIN " . DB_NAME . ".jobs
					ON users.user_id = jobs.user_id)
						LEFT JOIN " . DB_NAME . ".user_types
					ON users.user_id = user_types.user_type_id) 
				ON users.user_id = user_stars.star_id
				WHERE
					user_types.user_type = :user_type
				AND users.confirmed = :confirmed
				AND user_stars.starred_by_id = :starred_by
				AND users.user_id != :starred_by
				GROUP BY
					users.user_id,
					users.firstname, 
					users.lastname, 
					user_stars.star_id,
					employers.employer_name,
					employer_types.employer_type
			");
			$query->bindValue(":user_type", 'employer');
			$query->bindValue(":confirmed", 1);
			$query->bindValue(":starred_by", $starredBy);

			try{
				$query->execute();
				# We use fetchAll() instead of fetch() to get an array of all the selected records.
				return $query->fetchAll();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}
	}