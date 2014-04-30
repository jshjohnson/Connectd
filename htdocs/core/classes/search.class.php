<?php 
	class Search {

		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		    $this->freelancers = new Freelancers($this->db);
		    $this->jobs = new Jobs($this->db);
		}

		public function getFreelancersSearch($searchTerm, $sessionUserID) {
			$results = array();
			$all = $this->freelancers->getFreelancersAllTypes($sessionUserID);

			foreach($all as $freelancer) {
				$haystack = $freelancer['firstname'] . $freelancer['lastname'] . $freelancer['jobtitle'] . $freelancer['user_type'];
				if(stripos($haystack, $searchTerm) !== false) {
					$results[] = $freelancer; 
				}	
			}
			return $results;
		}

		public function getJobsSearch($searchTerm) {
			$results = array();
			$all = $this->jobs->getJobsAll();
			foreach($all as $job) {
				$haystack = $job['job_name'] . $job['employer_name'] . $job['job_location'];
				if(stripos($haystack, $searchTerm) !== false) {
					$results[] = $job; 
				}	
			}
			return $results;
		}


	}