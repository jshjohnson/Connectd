<?php
	class Jobs {
		
		// Properties
	 	
		private $db;

		// Methods
		
		public function __construct($database) {
		    $this->db = $database;
		}

		/**
		 * Gets all job categories (e.g. Web Design, Graphic Design etc) 
		 *
		 * @param  void
		 * @return array
		 */ 
		public function getJobCategories() {
	    	$query = $this->db->prepare("SELECT job_category FROM " . DB_NAME . ".job_categories");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			return $query->fetchAll();
	    }

		/**
		 * Inserts a job into the database
		 *
		 * @param  int $user_id
		 * @param  string $jobName
		 * @param  string $startDate
		 * @param  string $deadline
		 * @param  string $budget
		 * @param  string $category
		 * @param  string $description
		 * @return void
		 */ 
	    public function postJob($user_id, $jobName, $startDate, $deadline, $budget, $category, $description) {

    		$postDate = time();

			$query = $this->db->prepare("
				INSERT INTO " . DB_NAME . ".jobs
				(user_id, job_name, job_start_date, job_deadline, job_budget, job_category, job_description, job_post_date) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?)
			");
			$query->bindValue(1, $user_id);
			$query->bindValue(2, $jobName);
			$query->bindValue(3, $startDate);
			$query->bindValue(4, $deadline);
			$query->bindValue(5, $budget);
			$query->bindValue(6, $category);
			$query->bindValue(7, $description);
			$query->bindValue(8, $postDate);

	    	try {
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
	    }
	}