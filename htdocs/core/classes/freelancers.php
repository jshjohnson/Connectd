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
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$emailCode = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);

			$query 	= $this->db->prepare("
				INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, portfolio, bio, ip) 
				VALUES 
				(:firstname, :lastname, :email, :email_code, :password, :time_joined, :location, :portfolio, :bio, :ip)
			");
			
			$query->bindValue(":firstname", $firstName);
			$query->bindValue(":lastname", $lastName);
			$query->bindValue(":email", $email);
			$query->bindValue(":email_code", $emailCode);
			$query->bindValue(":password", $password);
			$query->bindValue(":time_joined", $time);
			$query->bindValue(":location", $location);
			$query->bindValue(":portfolio", $portfolio);
			$query->bindValue(":bio", $bio);
			$query->bindValue(":ip", $ip);
		 
			try{
				$query->execute();

		 		// Send verification email to user
				$general->sendEmail($firstName, $email, $emailCode);

				$rows = $query->rowCount();
	 
				if($rows > 0){

					$lastUserId =  $this->db->lastInsertId('user_id');
					
					$freelancersInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".freelancers (freelancer_id, jobtitle, priceperhour) VALUE (?,?,?)");
	 
	 				$freelancersInsert->bindValue(1, $lastUserId);
					$freelancersInsert->bindValue(2, $jobTitle);
					$freelancersInsert->bindValue(3, $pricePerHour);

					try{
						$freelancersInsert->execute();
					}catch(PDOException $e) {
						$general = new General($db);
						$general->errorView($general, $e);
					}						

					$userTypeInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_type_id, user_type) VALUE (?,?)");
	 
	 				$userTypeInsert->bindValue(1, $lastUserId);
					$userTypeInsert->bindValue(2, $userType);				
	 
					try{
						$userTypeInsert->execute();
					}catch(PDOException $e) {
						$general = new General($db);
						$general->errorView($general, $e);
					}

					$userExpInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_experience (experience_id, experience) VALUE (?,?)");

					$userExpInsert->bindValue(1, $lastUserId);
					$userExpInsert->bindValue(2, $experience);							
	
					try{
						$userExpInsert->execute();
					}catch(PDOException $e) {
						$general = new General($db);
						$general->errorView($general, $e);
					}

					if($userType == 'designer') {
						$jobTitleInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".designer_titles (job_title_id, job_title) VALUE (?,?)");

						$jobTitleInsert->bindValue(1, $lastUserId);
						$jobTitleInsert->bindValue(2, $jobTitle);	

						try{
							$jobTitleInsert->execute();
						}catch(PDOException $e) {
							$general = new General($db);
							$general->errorView($general, $e);
						}					

					} else if ($userType == 'developer') {
	 					$jobTitleInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".developer_titles (job_title_id, job_title) VALUE (?,?)");

		 				$jobTitleInsert->bindValue(1, $lastUserId);
						$jobTitleInsert->bindValue(2, $jobTitle);
						try{
							$jobTitleInsert->execute();
						}catch(PDOException $e) {
							$general = new General($db);
							$general->errorView($general, $e);
						}
					}
					
					return true;
				}
							
			}catch(PDOException $e) {
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

	    	if ($userType == "Developer") {

		    	$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".developer_titles LIKE 'job_title'");
				try{
					$query->execute();
				}catch(PDOException $e){
					echo "Sorry, there was an error: ".$e->getMessage();
				}
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				preg_match_all("/'(.*?)'/", $row['Type'], $categories);
				$fields = $categories[1];
				return $fields;

	    	} else if ($userType == "Designer") {
		    	$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".designer_titles LIKE 'job_title'");
				try{
					$query->execute();
				}catch(PDOException $e){
					echo "Sorry, there was an error: ".$e->getMessage();
				}
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				preg_match_all("/'(.*?)'/", $row['Type'], $categories);
				$fields = $categories[1];
				return $fields;
	    	}
	    }
	}