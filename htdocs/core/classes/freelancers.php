<?php
	class Freelancers {
			
		// Properties
	 	
		private $db;

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
					die($e->getMessage());
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
					die($e->getMessage());
				}
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				preg_match_all("/'(.*?)'/", $row['Type'], $categories);
				$fields = $categories[1];
				return $fields;
	    	}
	    }
	}