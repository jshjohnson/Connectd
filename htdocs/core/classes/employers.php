<?php
	class Employers {
	
		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		}

		/**
		 * Gets employer types (e.g. Software Development etc)
		 *
		 * @param  void
		 * @return array
		 */ 
		public function getEmployerTypes() {
			$query = $this->db->prepare("SHOW COLUMNS FROM " . DB_NAME . ".employer_types LIKE 'employer_type'");
			try{
				$query->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			preg_match_all("/'(.*?)'/", $row['Type'], $categories);
			$fields = $categories[1];
			return $fields;
	    }

		/**
		 * Gets all jobs that an employer has posted
		 *
		 * @param  int $employer_id
		 * @return array
		 */ 
		public function getEmployerJobs($employer_id) {
	    	$query = $this->db->prepare("SELECT * FROM " . DB_NAME . ".jobs WHERE user_id = ?");
	    	$query->bindValue(1, $employer_id);
			try{
				$query->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	    }

		/**
		 *   Register an employer user
		 *
		 * @param  string $firstName
		 * @param  string $lastName
		 * @param  string $email
		 * @param  string $password
		 * @param  string $location
		 * @param  string $portfolio
		 * @param  string $employerName
		 * @param  string $employerType
		 * @param  string $experience
		 * @param  string $bio
		 * @param  string $userType
		 * @return boolean
		 */ 
	    public function registerEmployer($firstName, $lastName, $email, $password, $location, $portfolio, $employerName, $employerType, $experience, $bio, $userType) {

			global $bcrypt; 
			global $general;
			
			$time = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			$emailCode = sha1($email + microtime());
			$password = $bcrypt->genHash($password);

			$register = $this->db->prepare("INSERT INTO " . DB_NAME . ".users
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
				// $general->sendConfirmationEmail($firstName, $email, $emailCode);

				$rows = $register->rowCount();
	 
				if($rows > 0 && $userType = 'employer'){

					$last_user_id =  $this->db->lastInsertId('user_id');
					
					$employerInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".employers (employer_id, employer_name) VALUE (?,?)");
	 
	 				$employerInsert->bindValue(1, $last_user_id);
					$employerInsert->bindValue(2, $employerName);

					$employerInsert->execute();

					$employerTypeInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".employer_types (employer_type_id, employer_type) VALUE (?, ?)");

					$employerTypeInsert->bindValue(1, $last_user_id);
					$employerTypeInsert->bindValue(2, $employerType);						

					$employerTypeInsert->execute();

					$userExpInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_experience (experience_id, experience) VALUE (?,?)");

					$userExpInsert->bindValue(1, $last_user_id);
					$userExpInsert->bindValue(2, $experience);							

					$userExpInsert->execute();

					$userTypeInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_type_id, user_type) VALUE (?,?)");
	 
	 				$userTypeInsert->bindValue(1, $last_user_id);
					$userTypeInsert->bindValue(2, $userType);						

					$userTypeInsert->execute();

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
		 * Restrict employers data to 6 most recent 
		 *
		 * @param  void
		 * @return array
		 */
		public function getEmployersRecent() {

			$recent = "";
			$all = get_employers_all();

			$total_employers = count($all);
			$position = 0;
			$list_view = "";

			foreach ($all as $employer) {
				$position = $position + 1;
				// if designer is one of the 4 most recent designers
				if ($total_employers - $position < 6) {
					$recent[] = $employer;
				}
			}
			return $recent;
		}
 
		/**
		 * Get data for all employers in db
		 *
		 * @param  void
		 * @return array
		 */ 
		public function getEmployersAll() {
			
			$results = $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, e.employer_id, e.employer_name, ut.*, et.*
				FROM (((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".employers AS e
				ON u.user_id = e.employer_id)
				LEFT JOIN " . DB_NAME . ".employer_types as et
				ON u.user_id = et.employer_type_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = ?
				AND ut.user_type = ?
			");
			$results->bindValue(1, 1);
			$results->bindValue(2, 'employer');

			try {
				$results->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
			
			$employers = $results->fetchAll(PDO::FETCH_ASSOC);

			return $employers;

		}

		/**
		 * Get data for a single employer
		 *
		 * @param  int $id 
		 * @return array
		 */ 
		public function getEmployersSingle($id) {

			$results = $this->db->prepare("
				SELECT u.*, e.*, et.*
				FROM (((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".employers AS e
				ON u.user_id = e.employer_id)
				LEFT JOIN " . DB_NAME . ".employer_types as et
				ON u.user_id = et.employer_type_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = ?
				AND u.user_id = ?
				AND ut.user_type = ?
			");

			$results->bindValue(1, 1);
			$results->bindValue(2, $id);
			$results->bindValue(3, 'employer');

			try {
				$results->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}

			$employers = $results->fetch(PDO::FETCH_ASSOC);
			
			return $employers;
		}
	}