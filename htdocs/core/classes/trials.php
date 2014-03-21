<?php
	class Trials {
	
		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		}

		public function getTrialUsers() {

			$query = $this->db->prepare("
				SELECT 
				user_types.user_type,
				users.user_id,
				users.confirmed,
				users.firstname, 
				users.lastname, 
				users.location, 
				user_experience.experience,
				users.portfolio,
				Count(user_votes.vote_id) 
				AS CountOfvote_id, 
				freelancers.jobtitle, 
				freelancers.priceperhour
				FROM users 
				AS voters
				RIGHT JOIN 
				((((users LEFT JOIN user_votes 
				ON users.user_id = user_votes.vote_id) 
				LEFT JOIN freelancers 
				ON users.user_id = freelancers.freelancer_id) 
				LEFT JOIN user_experience
				ON users.user_id = user_experience.experience_id) 
				LEFT JOIN user_types
				ON users.user_id = user_types.user_type_id) 
				ON voters.user_id = user_votes.vote_id
				WHERE user_types.user_type != ?
				AND users.confirmed = ?
				GROUP BY
				users.user_id,
				users.firstname, 
				users.lastname, 
				users.location,
				user_experience.experience,
				users.portfolio,
				user_votes.vote_id,
				freelancers.jobtitle, 
				freelancers.priceperhour
				HAVING CountOfvote_id < ?
			");
			$query->bindValue(1, 'employer');
			$query->bindValue(2, 1);
			$query->bindValue(3, 10);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function getTrialUser($user_id) {

			$query = $this->db->prepare("
				SELECT 
				users.user_id,
				Count(user_votes.vote_id) 
				AS CountOfvote_id
				FROM users 
				LEFT JOIN user_votes 
				ON users.user_id = user_votes.vote_id
				WHERE user_votes.vote_id = ?
				GROUP BY
				users.user_id,
				user_votes.vote_id
				HAVING CountOfvote_id < ?
			");
			$query->bindValue(1, $user_id);
			$query->bindValue(2, 10);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetch();
		}
	}