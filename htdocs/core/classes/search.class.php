<?php 
	class Search {

		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		    $this->freelancers = new Freelancers($this->db);
		    $this->jobs = new Jobs($this->db);
		    $this->employers = new Employers($this->db);
		}

		/**
		 * Generate search based on freelancers' data (check in haystack)
		 *
		 * @param  $searchTerm
		 * @param  $sessionUserID
		 * @return $results
		 */ 
		public function getFreelancersSearch($searchTerm, $sessionUserID) {
			$results = array();
			$all = $this->freelancers->getFreelancersAllTypes($sessionUserID);

			foreach($all as $freelancer) {
				$haystack = $freelancer['firstname'] . $freelancer['lastname'] . $freelancer['jobtitle'] . $freelancer['user_type'] . $freelancer['priceperhour'];
				if(stripos($haystack, $searchTerm) !== false) {
					$results[] = $freelancer; 
				}	
			}
			return $results;
		}

		/**
		 * Generate search based on employers' data (check in haystack)
		 *
		 * @param  $searchTerm
		 * @return $results
		 */ 
		public function getEmployersSearch($searchTerm) {
			$results = array();
			$all = $this->employers->getEmployersAll();

			foreach($all as $employer) {
				$haystack = $employer['employer_name'] . $employer['employer_type'];
				if(stripos($haystack, $searchTerm) !== false) {
					$results[] = $employer; 
				}	
			}
			return $results;
		}


		/**
		 * Generate search based on jobs' data (check in haystack)
		 *
		 * @param  $searchTerm
		 * @return $results
		 */ 
		public function getJobsSearch($searchTerm) {
			$results = array();
			$all = $this->jobs->getJobsAll();
			foreach($all as $job) {
				$haystack = $job['job_name'] . $job['job_location'] . $job['job_budget'];
				if(stripos($haystack, $searchTerm) !== false) {
					$results[] = $job; 
				}	
			}
			return $results;
		}


	}