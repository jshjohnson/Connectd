<?php
	class Freelancers {
			
		// Properties
	 	
		private $db;

		protected $firstName = null;
		protected $lastName = null;
		protected $email = null;
		protected $location = null;
		protected $portfolio = null;
		protected $jobTitle = null;
		protected $pricePerHour = null;
		protected $experience = null;
		protected $bio = null;
		protected $userType = null;

		// Methods
		
		public function __construct($database) {
		    $this->db = $database;
		}

		/**
		 * Register a freelancer user
		 *
		 * @param  string $firstName
		 * @param  string $lastName
		 * @param  string $email
		 * @param  string $password
		 * @param  string $location
		 * @param  string $portfolio
		 * @param  string $jobTitle
		 * @param  int    $pricePerHour
		 * @param  string $experience
		 * @param  string $bio
		 * @param  string $userType
		 * @return boolean
		 */ 
		public function registerFreelancer($firstName, $lastName, $email, $password, $location, $portfolio, $jobTitle, $pricePerHour, $experience, $bio, $userType){

			global $bcrypt;
			global $general;
			
			$time = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			$emailCode = sha1($email + microtime());
			$password = $bcrypt->genHash($password);

			$register = $this->db->prepare("
				INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, portfolio, bio, ip) 
				VALUES 
				(:firstname, :lastname, :email, :email_code, :password, :time_joined, :location, :portfolio, :bio, :ip)
			");
			
			$register->bindValue(":firstname", $firstName);
			$register->bindValue(":lastname", $lastName);
			$register->bindValue(":email", $email);
			$register->bindValue(":email_code", $emailCode);
			$register->bindValue(":password", $password);
			$register->bindValue(":time_joined", $time);
			$register->bindValue(":location", $location);
			$register->bindValue(":portfolio", $portfolio);
			$register->bindValue(":bio", $bio);
			$register->bindValue(":ip", $ip);

			$this->db->beginTransaction();
		 
			try{
				$register->execute();

		 		// Send verification email to user
				$general->sendConfirmationEmail($firstName, $email, $emailCode);

				$rows = $register->rowCount();
	 
				if($rows > 0){

					$lastUserId =  $this->db->lastInsertId('user_id');

					// Insert job title and price per hour
					
					$freelancersInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".freelancers (freelancer_id, jobtitle, priceperhour) VALUE (?,?,?)");
	 
	 				$freelancersInsert->bindValue(1, $lastUserId);
					$freelancersInsert->bindValue(2, $jobTitle);
					$freelancersInsert->bindValue(3, $pricePerHour);

					$freelancersInsert->execute();	

					// Insert user type					

					$userTypeInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_type_id, user_type) VALUE (?,?)");
	 
	 				$userTypeInsert->bindValue(1, $lastUserId);
					$userTypeInsert->bindValue(2, $userType);				
	 
					$userTypeInsert->execute();

					// Insert user experience

					$userExpInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_experience (experience_id, experience) VALUE (?,?)");

					$userExpInsert->bindValue(1, $lastUserId);
					$userExpInsert->bindValue(2, $experience);							
	
					$userExpInsert->execute();

					// Insert job title into respective table

					if($userType == 'designer') {
						$designerTitleInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".designer_titles (job_title_id, job_title) VALUE (?,?)");

						$designerTitleInsert->bindValue(1, $lastUserId);
						$designerTitleInsert->bindValue(2, $jobTitle);	

						$designerTitleInsert->execute();				

					} else if ($userType == 'developer') {
	 					$developerTitleInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".developer_titles (job_title_id, job_title) VALUE (?,?)");

		 				$developerTitleInsert->bindValue(1, $lastUserId);
						$developerTitleInsert->bindValue(2, $jobTitle);

						$developerTitleInsert->execute();
					}
					
					$this->db->commit();
					return true;
				}
							
			}catch(PDOException $e) {
				$this->db->rollback();
				$general = new General($db);
				$general->errorView($general, $e);
			}
		}

		/**
		 * Get freelancer job titles
		 *
		 * @param  string $userType The type of user
		 * @return array
		 */ 
	    public function getFreelancerJobTitles($userType) {

	    	if ($userType == "developer") {

		    	$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".developer_titles LIKE 'job_title'");
				try{
					$query->execute();
					$row = $query->fetch(PDO::FETCH_ASSOC);
				}catch(PDOException $e) {
					$general = new General($db);
					$general->errorView($general, $e);
				}

				preg_match_all("/'(.*?)'/", $row['Type'], $categories);
				$fields = $categories[1];
				return $fields;

	    	} else if ($userType == "designer") {
		    	$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".designer_titles LIKE 'job_title'");
				try{
					$query->execute();
					$row = $query->fetch(PDO::FETCH_ASSOC);
				}catch(PDOException $e) {
					$general = new General($db);
					$general->errorView($general, $e);
				}
				
				preg_match_all("/'(.*?)'/", $row['Type'], $categories);
				$fields = $categories[1];
				return $fields;
	    	}
	    }

	    /**
		 * Restrict developers data to 6 most recent 
		 *
		 * @param  void
		 * @return array
		 */ 
		public function getFreelancersRecent() {

			$recent = "";
			$all = get_freelancers_all();

			$total_freelancers = count($all);
			$position = 0;
			$list_view = "";

			foreach ($all as $freelancer) {
				$position = $position + 1;
				// if designer is one of the 4 most recent designers
				if ($total_freelancers - $position < 6) {
					$recent[] = $freelancer;
				}
			}
			return $recent;
		}

		/**
		 * Get data for all freelancers in db based on user type
		 *
		 * @param  void
		 * @return array
		 */ 
		public function getFreelancersAll($userType) {
			$results =  $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, f.freelancer_id, f.jobtitle, f.priceperhour, ut.*
				FROM ((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".freelancers AS f
				ON u.user_id = f.freelancer_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = ?
				AND ut.user_type = ?
			");
			$results->bindValue(1, 1);
			$results->bindValue(2, $userType);
			
			try {
				$results->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
			
			$freelancers = $results->fetchAll(PDO::FETCH_ASSOC);

			return $freelancers;

		}

		/**
		 * Get data for a single freelancer
		 *
		 * @param  int $id 
		 * @return array
		 */ 
		public function getFreelancersSingle($id, $userType) {

			$results = $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, u.email, u.bio, u.portfolio, u.location, u.time_joined, f.freelancer_id, f.jobtitle, f.priceperhour, ut.*
				FROM ((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".freelancers AS f
				ON u.user_id = f.freelancer_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = ?
				AND u.user_id = ?
				AND ut.user_type = ?
			");
			$results->bindValue(1, 1);
			$results->bindValue(2, $id);
			$results->bindValue(3, $userType);

			try {
				$results->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}

			$developers = $results->fetch(PDO::FETCH_ASSOC);
			
			return $developers;
		}
	}