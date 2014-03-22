<?php
	class Votes {
	 
		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		}

		/**
		 * Gets the number of votes of a particular user
		 *
		 * @param  integer  $id The user to test
		 * @return array
		 */ 
		public function getUserVotes($id) {
 
			$query = $this->db->prepare("
				SELECT COUNT(uv.vote_id) AS CountOfvote_id, u.user_id
				FROM " . DB_NAME . ".user_votes uv
				JOIN " . DB_NAME . ".users u ON uv.vote_id = u.user_id
				WHERE u.user_id = ? 
				AND u.user_id = uv.vote_id 
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
		 * Tests whether a user has less than 10 votes (and therefore unverified)
		 *
		 * @param  string  $email The logged in user's email
		 * @return boolean
		 */ 
		public function userVotedFor($email) {

			$query = $this->db->prepare("
				SELECT u.user_id, u.email, ut.user_type, COUNT(uv.vote_id) 
				AS CountOfvote_id
				FROM " . DB_NAME . ".users AS u
				LEFT JOIN user_votes  AS uv
				ON u.user_id = uv.vote_id
				LEFT JOIN user_types AS ut
				ON u.user_id = ut.user_type_id
				WHERE u.email = ?
				HAVING CountOfvote_id < ?
				AND ut.user_type != ?
			");

			$query->bindValue(1, $email);
			$query->bindValue(2, 3);
			$query->bindValue(3, 'employer');
			
			try{
				$query->execute();
				$rows = $query->fetch();
				
				if($rows < 1){
					return true;
				}else{
					return false;
				}
		 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		/**
		 * Redirects user based on boolean from userVotedFor()
		 *
		 * @param  void
		 * @return void
		 */ 
		public function userVotedForProtect() {

			if($this->userVotedFor($email) === true) {
				#Redirect the user to the dashboard
				header("Location:" . BASE_URL . "dashboard/");
				exit();
			} else if($this->userVotedFor($email) === false) {
				header("Location:" . BASE_URL . "welcome/");
				exit();
			}
		}

		/**
		 * Adds a vote to the database
		 *
		 * @param  integer  $user_id The user recieving a vote
		 * @param  integer  $votedBy The user logged in voting
		 * @return void
		 */ 
		public function addVote($user_id, $votedBy) {
			$query = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_votes (vote_id, voted_by_id) VALUES (?, ?)");

			$query->bindValue(1, $user_id);
			$query->bindValue(2, $votedBy);
			
			try{
				$query->execute();
				header("Location:" . BASE_URL . "trials?status=added");
			}catch(PDOException $e){
				die($e->getMessage());
			}	
	    }

	    /**
		 * Removes a vote from the database
		 *
		 * @param  integer  $user_id The user who recieved a vote
		 * @param  integer  $votedBy The user logged in voting
		 * @return void
		 */ 
	    public function removeVote($user_id, $votedBy) {
			$query = $this->db->prepare("DELETE FROM " . DB_NAME . ".user_votes WHERE user_votes.vote_id = ? AND user_votes.voted_by_id = ?");

			$query->bindValue(1, $user_id);
			$query->bindValue(2, $votedBy);
			
			try{
				$query->execute();
				header("Location:" . BASE_URL . "trials?status=removed");
			}catch(PDOException $e){
				die($e->getMessage());
			}	
	    }

		/**
		 * Tests whether the user logged in has voted for another user
		 *
		 * @param  integer  $vote_id The user getting a vote
		 * @param  integer  $votedBy The user logged in voting
		 * @return boolean
		 */ 
	    public function sessionUserVoted($vote_id, $votedBy) {
	    	$query = $this->db->prepare("
	    		SELECT uv.vote_id, uv.voted_by_id 
	    		FROM " . DB_NAME . ".user_votes AS uv
	    		WHERE uv.vote_id = ?
	    		AND uv.voted_by_id = ?
	    	");

	    	$query->bindValue(1, $vote_id);
	    	$query->bindValue(2, $votedBy);

			try{
				$query->execute();
				$rows = $query->rowCount();

				// If there are over 0 rows returned, the user has voted
				if($rows > 0){
					return true;
				}else{
					return false;
				}

			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}