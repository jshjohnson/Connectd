<?php 
	class Search {

		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		    $this->freelancers = new Freelancers($this->db);
		}

		public function getFreelancersSearch($searchTerm, $sessionUserID) {
			$results = array();
			$all = $this->freelancers->getFreelancersAllTypes($sessionUserID);
			foreach($all as $freelancer) {
				$haystack = $freelancer['firstname'] . $freelancer['lastname'];
				if(stripos($haystack, $searchTerm) !== false) {
					$results[] = $freelancer; 
				}	
			}
			return $results;
		}


	}