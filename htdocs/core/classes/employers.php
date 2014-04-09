<?php
	class Employers {
	
		// Properties
	 	
		private $db;

		// Methods

		public function __construct($database) {
		    $this->db = $database;
		    $this->bcrypt = new Bcrypt(12);
		    $this->emails = new Emails();
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
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
	    	$query = $this->db->prepare("SELECT * FROM " . DB_NAME . ".jobs WHERE user_id = :user_id");
	    	$query->bindValue(":user_id", $employer_id);
			try{
				$query->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	    }

		/**
		 *   Register an employer user
		 *
		 * @param  array $firstName, $lastName, $email, $password, $location, portfolio, $employerName, $employerType, $experience, $bio, $userType
		 * @return boolean
		 */ 
	    public function registerEmployer(array $data) {
			
			$time = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			$emailCode = sha1($data['email'] + microtime());
			$password = $this->bcrypt->genHash($data['password']);

			$register = $this->db->prepare("INSERT INTO " . DB_NAME . ".users
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
				$this->emails->sendConfirmationEmail($firstName, $email, $emailCode);

				$rows = $register->rowCount();
	 
				if($rows > 0 && $userType = 'employer'){

					$last_user_id =  $this->db->lastInsertId('user_id');
					
					$employerInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".employers (employer_id, employer_name) VALUE (:employer_id, :employer_name)");
	 
	 				$employerInsert->bindValue(":employer_id", $last_user_id);
					$employerInsert->bindValue(":employer_name", $data['employerName']);

					$employerInsert->execute();

					$employerTypeInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".employer_types (employer_type_id, employer_type) VALUE (:employer_id, :employer_type)");

					$employerTypeInsert->bindValue(":employer_id", $last_user_id);
					$employerTypeInsert->bindValue(":employer_type", $data['employerType']);						

					$employerTypeInsert->execute();

					$userExpInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_experience (experience_id, experience) VALUE (:employer_id, :experience)");

					$userExpInsert->bindValue(":employer_id", $last_user_id);
					$userExpInsert->bindValue(":experience", $data['experience']);							

					$userExpInsert->execute();

					$userTypeInsert = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_type_id, user_type) VALUE (:employer_id, :user_type)");
	 
	 				$userTypeInsert->bindValue(":employer_id", $last_user_id);
					$userTypeInsert->bindValue(":user_type", $data['userType']);						

					$userTypeInsert->execute();

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
		 * Restrict employers data to 6 most recent 
		 *
		 * @param  void
		 * @return array
		 */
		public function getEmployersRecent($userType) {

			$recent = "";
			$all = $this->getEmployersAll($userType);

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
		public function getEmployersAll($userType) {
			
			$results = $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, u.image_location, e.employer_id, e.employer_name, ut.*, et.*
				FROM (((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".employers AS e
				ON u.user_id = e.employer_id)
				LEFT JOIN " . DB_NAME . ".employer_types as et
				ON u.user_id = et.employer_type_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = :confirmed
				AND ut.user_type = :user_type
			");
			$results->bindValue(":confirmed", 1);
			$results->bindValue(":user_type", $userType);

			try {
				$results->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
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
				WHERE u.confirmed = :confirmed
				AND u.user_id = :user_id
				AND ut.user_type = :user_type
			");

			$results->bindValue(":confirmed", 1);
			$results->bindValue(":user_id", $id);
			$results->bindValue("user_type", 'employer');

			try {
				$results->execute();
			}catch(PDOException $e) {
				$users = new Users($db);
				$debug = new Errors();
				$debug->errorView($users, $e);	
			}

			$employers = $results->fetch(PDO::FETCH_ASSOC);
			
			return $employers;
		}
	}