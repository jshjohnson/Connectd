<?php
	class Votes {
	 
		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}

		public function getUserVotes($id) {
 
			$query = $this->db->prepare("
				SELECT COUNT(v.votes), v.user_id, u.user_id 
				FROM " . DB_NAME . ".users u, " . DB_NAME . ".user_votes v
				WHERE u.user_id = ? 
				AND u.user_id = v.user_id 
				");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}

		// Test if user has been verified into the community
		public function userVotedFor($email) {

			$query = $this->db->prepare("SELECT COUNT(*) FROM (
				(SELECT 1 FROM " . DB_NAME . ".users AS a, " . DB_NAME . ".votes as v WHERE a.email = ? AND v.votes >= ?)) z
			");

			$query->bindValue(1, $email);
			$query->bindValue(2, 10);
			
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

		public function addVote($user_id, $votedBy) {
			$query = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_votes (vote_id, voted_by_id) VALUES (?, ?)");

			$query->bindValue(1, $user_id);
			$query->bindValue(2, $votedBy);
			
			try{
				$query->execute();
				header("Location:" . BASE_URL . "trials?added");
			}catch(PDOException $e){
				die($e->getMessage());
			}	
	    }

	    public function removeVote($user_id, $votedBy) {
			$query = $this->db->prepare("DELETE FROM " . DB_NAME . ".user_votes WHERE user_votes.vote_id = ? AND user_votes.voted_by_id = ?");

			$query->bindValue(1, $user_id);
			$query->bindValue(2, $votedBy);
			
			try{
				$query->execute();
				header("Location:" . BASE_URL . "trials?removed");
			}catch(PDOException $e){
				die($e->getMessage());
			}	
	    }

	    // vote_id = the person getting voted
	    // voted_by_id = the person voting

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