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
			}catch(PDOException $e){
				die($e->getMessage());
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
			}catch(PDOException $e){
				die($e->getMessage());
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

			global $bcrypt; // making the $bcrypt variable global so we can use here
			global $mail;
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);

			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, portfolio, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			$query->bindValue(1, $firstName);
			$query->bindValue(2, $lastName);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $password);
			$query->bindValue(6, $time);
			$query->bindValue(7, $location);
			$query->bindValue(8, $portfolio);
			$query->bindValue(9, $bio);
			$query->bindValue(10, $ip);
		 
			try{
				$query->execute();
		 
			// 	$to = $email;

			// 	$mail->Host               = DB_EMAIL;  // specify main and backup server
			// 	$mail->Username           = "josh@joshuajohnson.co.uk";  // SMTP username
			// 	$mail->Password           = "cheeseball27"; // SMTP password
			// 	$mail->SMTPAuth           = true;               // enable SMTP authentication
			// 	$mail->SMTPSecure         = "tls"; 
			// 	$mail->addAddress($to);  // Add a recipient
                
   //              $mail->From               = 'robot@connectd.io';
			// 	$mail->FromName           = 'Connectd.io';
   //              // Set word wrap to 50 characters
			// 	$mail->isHTML(true); // Set email format to HTML

			// 	$mail->Subject            = 'Activate your new Connectd account';

			// 	$mail->Body               = "<p>Hey " . $firstname . "!</p>";
			// 	$mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
			// 	$mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $email_code . "</p>";
			// 	$mail->Body              .= "<p>-- Connectd team</p>";
			// 	$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
			// 	$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";
			// 	$mail->AltBody            = 'This is the body in plain text for non-HTML mail clients';

			// 	if(!$mail->send()) {
			// 	   echo 'Message could not be sent.';
			// 	   echo 'Mailer Error: ' . $mail->ErrorInfo;
			// 	   exit;
			// 	}


				$rows = $query->rowCount();
	 
				if($rows > 0 && $userType = 'employer'){

					$last_user_id =  $this->db->lastInsertId('user_id');
					
					$query_2 = $this->db->prepare("INSERT INTO " . DB_NAME . ".employers (employer_id, employer_name) VALUE (?,?)");
	 
	 				$query_2->bindValue(1, $last_user_id);
					$query_2->bindValue(2, $employerName);

					$query_2->execute();


					$query_3 = $this->db->prepare("INSERT INTO " . DB_NAME . ".employer_types (employer_type_id, employer_type) VALUE (?, ?)");

					$query_3->bindValue(1, $last_user_id);
					$query_3->bindValue(2, $employerType);						
	 
					$query_3->execute();


					$query_4 = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_experience (experience_id, experience) VALUE (?,?)");

					$query_4->bindValue(1, $last_user_id);
					$query_4->bindValue(2, $experience);							
	 
					$query_4->execute();


					$query_5 = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_type_id, user_type) VALUE (?,?)");
	 
	 				$query_5->bindValue(1, $last_user_id);
					$query_5->bindValue(2, $userType);				
	 
					$query_5->execute();
					
					return true;

				}
							
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		/**
		 * Restrict employers data to 6 most recent 
		 *
		 * @param  void
		 * @return array
		 */
		public function get_employers_recent() {

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
		public function get_employers_all() {
			
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
			} catch (Exception $e) {
				echo "Damn. All employer data could not be retrieved.";
				exit;
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
		public function get_employers_single($id) {

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
			} catch (Exception $e) {
				echo "Damn. Single employer data could not be retrieved.";
				exit;
			}

			$employers = $results->fetch(PDO::FETCH_ASSOC);
			
			return $employers;
		}
	}