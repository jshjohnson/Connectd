<?php
	class Votes {
	 
		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		    $this->emails = new Emails();
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
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
				SELECT u.email, u.granted_access
				FROM " . DB_NAME . ".users AS u
				WHERE u.email = :email
			");

			$query->bindValue(":email", $email);
			
			try{
				$query->execute();
				return $row = $query->fetch();
				
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
				header("Location:" . BASE_URL . "welcome/");
				exit();
			} else if($this->userVotedFor($email) === false) {
				header("Location:" . BASE_URL . "dashboard/");
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
			
			$this->db->beginTransaction();

			try{
				$query->execute();

				$getUserInfo = $this->db->prepare("SELECT u.firstname, u.email, u.user_id FROM " . DB_NAME . ".users AS u WHERE u.user_id = ?");
				$getUserInfo->bindValue(1, $user_id);

				$getUserInfo->execute();
				$row = $getUserInfo->fetch();

				$firstName = $row['firstname'];
				$email = $row['email'];

				$votes = $this->getUserVotes($user_id);

				$voteCount = $votes['CountOfvote_id'];

				if($voteCount == 10) {
					$this->emails->sendTrialEndedEmail($firstName, $email);
					$grantAccess = $this->db->prepare("UPDATE " . DB_NAME . ".users SET users.granted_access = :granted_access WHERE users.email = :email");
					$grantAccess->bindValue(":granted_access", 1);
					$grantAccess->bindValue(":email", $email);
					try {
						$grantAccess->execute();
					}catch(PDOException $e) {
						$users = new Users($db);
						$debug = new Errors();
						$debug->errorView($users, $e);	
					}
					
				} else {
					$this->emails->sendVoteEmail($firstName, $email, $votes);
				}

				$this->db->commit();

				header("Location:" . BASE_URL . "trials/vote-added/");

			}catch(PDOException $e) {
				if ($e->errorInfo[1] == 1062) {
					try {
						throw new Exception("You cannot vote for a user twice.");
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
				header("Location:" . BASE_URL . "trials/vote-removed/");
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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

			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}
	}