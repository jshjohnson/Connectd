<?php
	class Freelancers {
			
		// Properties
	 	
		private $db;

		// Methods
		
		public function __construct($database) {
		    $this->db = $database;
		    $this->bcrypt = new Bcrypt(12);
		    $this->emails = new Emails();
		}

		/**
		 * Register a freelancer user
		 *
		 * @param  array $firstName, $lastName, $email, $password, $location, $portfolio, $jobTitle, $pricePerHour, $experience, $bio, $userType
		 * @return boolean
		 */ 
		public function registerFreelancer(array $data){
			
			$time = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			$emailCode = sha1($data['email'] + microtime());
			$password = $this->bcrypt->genHash($data['password']);

			$register = $this->db->prepare("
				INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, portfolio, bio, ip) 
				VALUES 
				(:firstname, :lastname, :email, :email_code, :password, :time_joined, :location, :portfolio, :bio, :ip)
			");
			
			$register->bindValue(":firstname", $data['firstName']);
			$register->bindValue(":lastname", $data['lastName']);
			$register->bindValue(":email", $data['email']);
			$register->bindValue(":email_code", $emailCode);
			$register->bindValue(":password", $password);
			$register->bindValue(":time_joined", $time);
			$register->bindValue(":location", $data['location']);
			$register->bindValue(":portfolio", $data['portfolio']);
			$register->bindValue(":bio", $data['bio']);
			$register->bindValue(":ip", $ip);

			$this->db->beginTransaction();
		 
			try{
				$register->execute();

		 		// Send verification email to user
				$this->emails->sendConfirmationEmail($data['firstName'], $data['email'], $emailCode);

				$rows = $register->rowCount();
	 
				if($rows > 0){

					$lastUserId =  $this->db->lastInsertId('user_id');

					// Insert job title and price per hour
					
					$freelancersInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".freelancers (freelancer_id, jobtitle, priceperhour) VALUE (?,?,?)");
	 
	 				$freelancersInsert->bindValue(1, $lastUserId);
					$freelancersInsert->bindValue(2, $data['jobTitle']);
					$freelancersInsert->bindValue(3, $data['pricePerHour']);

					$freelancersInsert->execute();	

					// Insert user type					

					$userTypeInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_type_id, user_type) VALUE (?,?)");
	 
	 				$userTypeInsert->bindValue(1, $lastUserId);
					$userTypeInsert->bindValue(2, $data['userType']);				
	 
					$userTypeInsert->execute();

					// Insert user experience

					$userExpInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_experience (experience_id, experience) VALUE (?,?)");

					$userExpInsert->bindValue(1, $lastUserId);
					$userExpInsert->bindValue(2, $data['experience']);							
	
					$userExpInsert->execute();

					$this->db->commit();
					return true;
				}
							
			}catch(PDOException $e) {
				$this->db->rollback();
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
					$users = new Users($db);
					
					$debug->errorView($users, $e);	
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
					$users = new Users($db);
					
					$debug->errorView($users, $e);	
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
		public function getFreelancersRecent($userType) {

			$recent = "";
			$all = $this->getFreelancersAll($userType);

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
				SELECT u.user_id, u.firstname, u.lastname, u.image_location, u.time_joined, f.freelancer_id, f.jobtitle, f.priceperhour, ut.*
				FROM ((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".freelancers AS f
				ON u.user_id = f.freelancer_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = :confirmed
				AND u.granted_access = :granted_access
				AND ut.user_type = :user_type
				ORDER BY u.time_joined DESC
			");
			$results->bindValue(":confirmed", 1);
			$results->bindValue(":granted_access", 1);
			$results->bindValue(":user_type", $userType);
			
			try {
				$results->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
			
			$freelancers = $results->fetchAll(PDO::FETCH_ASSOC);

			return $freelancers;
		}

		/**
		 * Get data for all freelancers in db
		 *
		 * @param  void
		 * @return array
		 */ 
		public function getFreelancersAllTypes($user_id) {
			$results = $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, u.image_location, u.time_joined, f.freelancer_id, f.jobtitle, f.priceperhour, ut.*
				FROM ((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".freelancers AS f
				ON u.user_id = f.freelancer_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = :confirmed
				AND u.granted_access = :granted_access
				AND u.user_id != :user_id
				AND ut.user_type != :user_type
				ORDER BY u.time_joined DESC
			");
			$results->bindValue(":confirmed", 1);
			$results->bindValue(":granted_access", 1);
			$results->bindValue(":user_id", $user_id);
			$results->bindValue(":user_type", "employer");
			
			
			try {
				$results->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
			
			$freelancers = $results->fetchAll(PDO::FETCH_ASSOC);

			return $freelancers;
		}

		public function getFreelancersAllTypesCount($user_id) {
			return count(getFreelancersAllTypes($user_id));
		}

		/**
		 * Get data for a single freelancer
		 *
		 * @param  int $id 
		 * @return array
		 */ 
		public function getFreelancersSingle($id, $userType) {

			$results = $this->db->prepare("
				SELECT 
					u.user_id, u.firstname, u.lastname, u.email, u.bio, u.portfolio, u.location, u.time_joined, u.image_location, 
					f.jobtitle, f.priceperhour, 
					ut.user_type,
					ft.testimonial, ft.testimonial_source
				FROM (((" . DB_NAME . ".users AS u
					LEFT JOIN " . DB_NAME . ".freelancers AS f
				ON u.user_id = f.freelancer_id)
					LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id AND ut.user_type = :userType)
					LEFT JOIN " . DB_NAME . ".freelancer_testimonials AS ft
				ON u.user_id = ft.testimonial_id)
				WHERE 
					u.confirmed = :confirmed
				AND u.user_id = :userID
				AND u.granted_access = :grantedAccess
			");

			$results->bindValue(":confirmed", 1);
			$results->bindValue(":userID", $id);
			$results->bindValue(":userType", $userType);
			$results->bindValue(":grantedAccess", 1);

			try {
				$results->execute();
				$user = $results->fetch(PDO::FETCH_ASSOC);

				return $user;
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
		}

		public function getFreelancerSkills($id) {
			$results = $this->db->prepare("
				SELECT 
					fs.skill, fs.skill_rating
				FROM " . DB_NAME . ".freelancer_skills as fs
				WHERE
					fs.skill_id = :userID
			");

			$results->bindValue(":userID", $id);

			try {
				$results->execute();
				$skills = $results->fetchAll(PDO::FETCH_ASSOC);

				return $skills;
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}	
		}
	}