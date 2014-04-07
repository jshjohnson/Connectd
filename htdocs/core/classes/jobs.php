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
			}catch(PDOException $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
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
	    public function postJob($user_id, $jobFull, $startDate, $deadline, $budget, $category, $description) {

    		$postDate = time();

			$query = $this->db->prepare("
				INSERT INTO " . DB_NAME . ".jobs
				(user_id, job_name, job_start_date, job_deadline, job_budget, job_category, job_description, job_post_date) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?)
			");
			$query->bindValue(1, $user_id);
			$query->bindValue(2, $jobFull);
			$query->bindValue(3, $startDate);
			$query->bindValue(4, $deadline);
			$query->bindValue(5, $budget);
			$query->bindValue(6, $category);
			$query->bindValue(7, $description);
			$query->bindValue(8, $postDate);

	    	try {
				$query->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}
	    }
 
		/**
		 * Get data for all jobs in db
		 *
		 * @param  void
		 * @return array
		 */ 
		public function getJobsAll() {
			$results = $this->db->prepare("SELECT 
				j.*, u.user_id, ut.user_type_id, ut.user_type, e.employer_name
				FROM (((" . DB_NAME . ".jobs AS j
				LEFT JOIN " . DB_NAME . ".users AS u
				ON j.user_id = u.user_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON j.user_id = ut.user_type_id)
				LEFT JOIN " . DB_NAME . ".employers AS e 
				ON j.user_id = e.employer_id)
			");
			try {
				$results->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}
			
			$jobs = $results->fetchAll(PDO::FETCH_ASSOC);

			return $jobs;
		}

		public function getJobsSingle($id) {

			$results = $this->db->prepare("SELECT
				j.*, u.user_id, u.location, u.portfolio, u.bio, u.time_joined, e.employer_name, et.employer_type
				FROM (((" . DB_NAME . ".jobs AS j
				INNER JOIN " . DB_NAME . ".users AS u 
				ON j.user_id = u.user_id)
				INNER JOIN " . DB_NAME . ".employers AS e 
				ON j.user_id = e.employer_id)
				INNER JOIN " . DB_NAME . ".employer_types AS et 
				ON j.user_id = et.employer_type_id)
				WHERE j.job_id = ?
			");
			$results->bindValue(1, $id);
			try {
				$results->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$general = new General($db);
				$general->errorView($users, $general, $e);
			}

			$jobs = $results->fetch(PDO::FETCH_ASSOC);
			
			return $jobs;
		}

		/**
		 * Restrict jobs data to 6 most recent 
		 *
		 * @param  void
		 * @return array
		 */ 		
		public function getJobsRecent() {

			$recent = "";
			$all = get_jobs_all();

			$total_jobs = count($all);
			$position = 0;
			$list_view = "";

			foreach ($all as $job) {
				$position = $position + 1;
				// if designer is one of the 4 most recent jobs
				if ($total_jobs - $position < 6) {
					$recent[] = $job;
				}
			}
			return $recent;
		}
	}