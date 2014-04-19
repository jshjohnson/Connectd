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
		 * Gets the number of stars of a particular user
		 *
		 * @param  integer  $id The user to test
		 * @return array
		 */ 
		public function getUserStars($id) {
 
			$query = $this->db->prepare("
				SELECT COUNT(uv.star_id) AS CountOfstar_id, u.user_id
				FROM " . DB_NAME . ".user_stars uv
				JOIN " . DB_NAME . ".users u ON uv.star_id = u.user_id
				WHERE u.user_id = ? 
				AND u.user_id = uv.star_id 
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
				$row = $getUserInfo->fetch();

				$this->db->commit();

				header('Location: ' . $_SERVER['HTTP_REFERER'] . "&status=sent");

			}catch(PDOException $e) {
				if ($e->errorInfo[1] == 1062) {
					try {
						throw new Exception("You cannot star for a user twice.");
					}catch(Exception $e) {
						$this->db->rollback();
						$users = new Users($db);
						$debug = new Errors();
						$debug->errorView($users, $e);	
					}		
				}else {
					$this->db->rollback();
					$users = new Users($db);
					$debug = new Errors();
					$debug->errorView($users, $e);	
				}
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
				header("Location:" . BASE_URL . "trials/?status=removed");
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
	    public function sessionUserStarred($star_id, $starredBy) {
	    	$query = $this->db->prepare("
	    		SELECT uv.star_id, uv.starred_by_id 
	    		FROM " . DB_NAME . ".user_stars AS uv
	    		WHERE uv.star_id = ?
	    		AND uv.starred_by_id = ?
	    	");

	    	$query->bindValue(1, $star_id);
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
	}