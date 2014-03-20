<?php
	class Users {
	 
		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		// Test if email already exists in database
		public function emailExists($email) {
		 
			$query = $this->db->prepare("SELECT `email`
						FROM " . DB_NAME . ".users
						WHERE `email` = ? 
					");
			$query->bindParam(1, $email);

			try{
		 
				$query->execute();
				$rows = $query->rowCount();
		 
				if($rows > 0){
					return true;
				}else{
					return false;
				}
		 
			} catch (PDOException $e){
				die($e->getMessage());
			}
		 
		}

		// Test if user has confirmed their email
		public function emailConfirmed($email) {
 
			$query = $this->db->prepare("SELECT COUNT(*) FROM (
				(SELECT 1 FROM " . DB_NAME . ".users AS a WHERE a.email = ? AND a.confirmed = ?)) z
			");

			$query->bindValue(1, $email);
			$query->bindValue(2, 1);
			
			try{
				
				$query->execute();
				$rows = $query->fetchColumn();
		 
				if($rows == 1){
					return true;
				}else{
					return false;
				}
		 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function login($email, $password) {

			global $bcrypt;  // Make the bcrypt variable global, which is defined in init.php, which is included in login.php where this function is called
 
			$query = $this->db->prepare("SELECT 
					`user_id`, `email`, `password`
					FROM " . DB_NAME . ".users
					WHERE `email` = ? 
				");
			$query->bindValue(1, $email);
			
			try{
				
				$query->execute();
				$data 				= $query->fetch();
				$stored_password 	= $data['password'];
				$id 				= $data['user_id'];
				
				// hashing the supplied password and comparing it with the stored hashed password.
				if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
					return $id;	
				}else{
					return false;	
				}
		 
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function getTrialUsers() {

			$query = $this->db->prepare("
					SELECT 
					user_types.user_type,
					users.user_id,
					users.firstname, 
					users.lastname, 
					users.location, 
					user_experience.experience,
					users.portfolio,
					Count(user_votes.vote_id) 
					AS CountOfvote_id, 
					freelancers.jobtitle, 
					freelancers.priceperhour
					FROM users 
					AS voters
					RIGHT JOIN 
					((((users LEFT JOIN user_votes 
					ON users.user_id = user_votes.vote_id) 
					LEFT JOIN freelancers 
					ON users.user_id = freelancers.freelancer_id) 
					LEFT JOIN user_experience
					ON users.user_id = user_experience.experience_id) 
					LEFT JOIN user_types
					ON users.user_id = user_types.user_type_id) 
					ON voters.user_id = user_votes.vote_id
					WHERE user_types.user_type != ?
					GROUP BY
					users.user_id,
					users.firstname, 
					users.lastname, 
					users.location,
					user_experience.experience,
					users.portfolio,
					user_votes.vote_id,
					freelancers.jobtitle, 
					freelancers.priceperhour
					HAVING CountOfvote_id < ?
			");
			$query->bindValue(1, 'employer');
			$query->bindValue(2, 10);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		// Get user data
		public function userData($id) {
			$query = $this->db->prepare("
				SELECT users.firstname, users.lastname, users.email, user_types.*
				FROM " . DB_NAME . ".users 
				JOIN " . DB_NAME . ".user_types 
				ON users.user_id = user_types.user_type_id
				WHERE users.user_id= ?
				");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}
		
		public function activateUser($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");
	 
					$query_2->bindValue(1, 1);
					$query_2->bindValue(2, $email);							
	 
					$query_2->execute();
					return true;
				} else {
					return false;
				}
	 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		// Register a developer on sign up
		public function registerFreelancer($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $priceperhour, $experience, $bio, $userType){

			global $bcrypt; // making the $bcrypt variable global so we can use here
			global $mail;
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);// generating a hash using the $bcrypt object

			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, portfolio, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
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
		 
				// $to = $email;

				// $mail->Host               = DB_EMAIL;  // specify main and backup server
				// $mail->Username           = "josh@joshuajohnson.co.uk";  // SMTP username
				// $mail->Password           = "cheeseball27"; // SMTP password
				// $mail->SMTPAuth           = true;               // enable SMTP authentication
				// $mail->SMTPSecure         = "tls"; 
				// $mail->addAddress($to);  // Add a recipient=
                
    //             $mail->From               = 'robot@connectd.io';
				// $mail->FromName           = 'Connectd.io';
    //             // Set word wrap to 50 characters
				// $mail->isHTML(true); // Set email format to HTML

				// $mail->Subject            = 'Activate your new Connectd account';

				// $mail->Body               = "<p>Hey " . $firstname . "!</p>";
				// $mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				// $mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $email_code . "</p>";
				// $mail->Body              .= "<p>-- Connectd team</p>";
				// $mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				// $mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";
				// $mail->AltBody            = 'This is the body in plain text for non-HTML mail clients';

				// if(!$mail->send()) {
				//    echo 'Message could not be sent.';
				//    echo 'Mailer Error: ' . $mail->ErrorInfo;
				//    exit;
				// }


				$rows = $query->rowCount();
	 
				if($rows > 0){

					$last_user_id =  $this->db->lastInsertId('user_id');
					
					$query_2 = $this->db->prepare("INSERT INTO " . DB_NAME . ".freelancers (freelancer_id, jobtitle, priceperhour) VALUE (?,?,?)");
	 
	 				$query_2->bindValue(1, $last_user_id);
					$query_2->bindValue(2, $jobtitle);
					$query_2->bindValue(3, $priceperhour);						
	 
					$query_2->execute();

					$query_3 = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_type_id, user_type) VALUE (?,?)");
	 
	 				$query_3->bindValue(1, $last_user_id);
					$query_3->bindValue(2, $userType);				
	 
					$query_3->execute();

					$query_4 = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_experience (experience_id, experience) VALUE (?,?)");

					$query_4->bindValue(1, $last_user_id);
					$query_4->bindValue(2, $experience);							
	 
					$query_4->execute();

					if($userType == 'designer') {
						$query_5 = $this->db->prepare("INSERT INTO " . DB_NAME . ".designer_titles (job_title_id, job_title) VALUE (?,?)");

						$query_5->bindValue(1, $last_user_id);
						$query_5->bindValue(2, $jobtitle);				
		 
						$query_5->execute();

					} else if ($userType == 'developer') {
	 					$query_5 = $this->db->prepare("INSERT INTO " . DB_NAME . ".developer_titles (job_title_id, job_title) VALUE (?,?)");

		 				$query_5->bindValue(1, $last_user_id);
						$query_5->bindValue(2, $jobtitle);				
		 
						$query_5->execute();
					}
					
					return true;
				}
							
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function registerEmployer($firstname, $lastname, $email, $password, $location, $portfolio, $employerName, $employerType, $experience, $bio, $userType) {

			global $bcrypt; // making the $bcrypt variable global so we can use here
			global $mail;
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);// generating a hash using the $bcrypt object

			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, portfolio, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
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
	}