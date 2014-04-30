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
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
	    public function postJob($user_id, $jobFull, $jobLocation, $startDate, $deadline, $budget, $category, $description) {

    		$postDate = time();

			$query = $this->db->prepare("
				INSERT INTO " . DB_NAME . ".jobs
				(user_id, job_name, job_location, job_start_date, job_deadline, job_budget, job_category, job_description, job_post_date) 
				VALUES 
				(:user_id, :name, :location, :start_date, :deadline, :budget, :category, :description, :date)
			");

			$query->bindValue(":user_id", $user_id);
			$query->bindValue(":name", $jobFull);
			$query->bindValue(":location", $jobLocation);
			$query->bindValue(":start_date", $startDate);
			$query->bindValue(":deadline", $deadline);
			$query->bindValue(":budget", $budget);
			$query->bindValue(":category", $category);
			$query->bindValue(":description", $description);
			$query->bindValue(":date", $postDate);

	    	try {
				$query->execute();
			}catch(PDOException $e) {
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
	    }

	 	/**
		 *  Present time in terms of years, days, weeks, minutes or seconds ago
		 *
		 * @param  int $i The time a user signed up (`time_joined`)
		 * @return string
		 */ 
		public function timeAgo($i){
			$m = time()-$i; $o='just now';
			$t = array('year'=>31556926,'month'=>2629744,'week'=>604800,
			'day'=>86400,'hour'=>3600,'minute'=>60,'second'=>1);
			foreach($t as $u=>$s){
				if($s<=$m){$v=floor($m/$s); $o="$v $u".($v==1?'':'s').' ago'; break;}
			}
			return $o;
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
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
			
			$jobs = $results->fetchAll(PDO::FETCH_ASSOC);

			return $jobs;
		}

		public function getEmployerJobs($sessionUserID) {
			$query = $this->db->prepare("SELECT 
				j.*, u.user_id, ut.user_type_id, ut.user_type, e.employer_name
				FROM (((" . DB_NAME . ".jobs AS j
				LEFT JOIN " . DB_NAME . ".users AS u
				ON j.user_id = u.user_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON j.user_id = ut.user_type_id)
				LEFT JOIN " . DB_NAME . ".employers AS e 
				ON j.user_id = e.employer_id)
				WHERE j.user_id = ?
			");

			$query->bindValue(1, $sessionUserID);

			try {
				$query->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
			
			$jobs = $query->fetchAll(PDO::FETCH_ASSOC);

			return $jobs;
		}

		public function getJobsSingle($id) {

			$results = $this->db->prepare("SELECT
				j.*, u.user_id, u.location, u.portfolio, u.bio, u.time_joined, u.image_location, e.employer_name, et.employer_type
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
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}

			$jobs = $results->fetch(PDO::FETCH_ASSOC);
			
			return $jobs;
		}

		/**
		 * Restrict jobs data to 10 most recent 
		 *
		 * @param  void
		 * @return array
		 */ 		
		public function getJobsRecent() {

			$recent = "";
			$all = $this->getJobsAll();

			$total_jobs = count($all);
			$position = 0;
			$list_view = "";

			foreach ($all as $job) {
				$position = $position + 1;
				// if designer is one of the 4 most recent jobs
				if ($total_jobs - $position < 10) {
					$recent[] = $job;
				}
			}
			return $recent;
		}
	}