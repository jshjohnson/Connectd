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
 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT 
				users.user_id, users.firstname, users.lastname, users.location, users.portfolio, users.experience, users.votes, users.time_joined, freelancers.jobtitle
				FROM " . DB_NAME . ".users, " . DB_NAME . ".freelancers WHERE `votes` < ? AND `user_type` != ? AND users.user_id = freelancers.user_id");

			$query->bindValue(1, 10);
			$query->bindValue(2, 'employer');

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
				SELECT firstname, lastname, user_type FROM " . DB_NAME . ".users WHERE `user_id`= ?
				");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}

		// Test if user has been verified into the community
		public function userVotedFor($email) {
 
			$query = $this->db->prepare("SELECT `email`
						FROM " . DB_NAME . ".users
						WHERE `votes` >= ? 
					");
			$query->bindValue(1, 10);
			
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

		public function userVotedForProtect() {

			if($this->userVotedFor($email) === true) {
				#Redirect the user to the dashboard
				header("Location:" . BASE_URL . "dashboard/");
				exit();
			} else if($this->userVotedFor($email) === false) {
				header("Location:" . BASE_URL . "welcome/");
				exit();
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
		public function registerUser($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $priceperhour, $experience, $bio, $user_type, $votes){

			global $bcrypt; // making the $bcrypt variable global so we can use here
			global $mail;
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);// generating a hash using the $bcrypt object

			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, experience, portfolio, bio, ip, user_type, votes) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $password);
			$query->bindValue(6, $time);
			$query->bindValue(7, $location);
			$query->bindValue(8, $experience);
			$query->bindValue(9, $portfolio);
			$query->bindValue(10, $bio);
			$query->bindValue(11, $ip);
			$query->bindValue(12, $user_type);
			$query->bindValue(13, $votes);
			
		 
			try{
				$query->execute();
		 
				// $to = $email;

				// $mail->Host = "localhost";  // specify main and backup server
				// $mail->Username = "josh@joshuajohnson.co.uk";  // SMTP username
				// $mail->Password = "cheeseball27"; // SMTP password
				// $mail->SMTPAuth = true;     // turn on SMTP authentication
				// $mail->addAddress($to);  // Add a recipient=
                
    //             $mail->From = 'robot@connectd.io';
				// $mail->FromName = 'Connectd.io';
    //             // Set word wrap to 50 characters
				// $mail->isHTML(true); // Set email format to HTML

				// $mail->Subject = 'Activate your new Connectd account';

				// $mail->Body = "<p>Hey " . $firstname . "!</p>";
				// $mail->Body .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				// $mail->Body .= "<p>" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "</p>";
				// $mail->Body .= "<p>-- Connectd team</p>";
				// $mail->Body .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				// $mail->Body .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";
				// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				// if(!$mail->send()) {
				//    echo 'Message could not be sent.';
				//    echo 'Mailer Error: ' . $mail->ErrorInfo;
				//    exit;
				// }


				$rows = $query->rowCount();
	 
				if($rows > 0){

					$last_user_id =  $this->db->lastInsertId('user_id');
					
					$query_2 = $this->db->prepare("INSERT INTO " . DB_NAME . ".freelancers (user_id, jobtitle, priceperhour) VALUE (?,?,?)");
	 
	 				$query_2->bindValue(1, $last_user_id);
					$query_2->bindValue(2, $jobtitle);
					$query_2->bindValue(3, $priceperhour);						
	 
					$query_2->execute();
					
					return true;

				} else {
					return false;
				}
							
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function getUserVotes($id) {
 
			$query = $this->db->prepare("
				SELECT votes FROM " . DB_NAME . ".users WHERE `user_id`= ?
				");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}

		public function validateUser($firstname, $lastname, $email, $password, $portfolio, $jobtitle, $experience, $bio) {

			global $mail;	

			$r1='/[A-Z]/';  // Test for an uppercase character
			$r2='/[a-z]/';  // Test for a lowercase character
			$r3='/[0-9]/';  // Test for a number

			if($firstname == ""){
			    $errors[] ="Please enter your first name";
			    return;
			}else if($lastname == ""){
			    $errors[] ="Please enter your last name";
			    return;
			}else if($email == ""){
			    $errors[] ="Please enter your email";
			    return;
			}else if (!$mail->ValidateAddress($email)){
				$errors[] = "You must specify a valid email address.";
				return;
			}else if ($users->emailExists($email) === true) {
			    $errors[] = "Email already taken. Please try again.";
			    return;
			}else if($password == ""){
			    $errors[] ="Please enter a password"; 
			    return;
			}else if ($password!=$repeatpassword){ 
				$errors[] = "Both password fields must match";
				return;
			} else if(preg_match_all($r1,$password)<1) {
				$errors[] = "Your password needs to contain at least one uppercase character";
				return;
			} else if(preg_match_all($r2,$password)<1) {
				$errors[] = "Your password needs to contain at least one lowercase character";
				return;
			} else if(preg_match_all($r3,$password)<1) {
				$errors[] = "Your password needs to contain at least one number";
				return;
			} else if (strlen($password)>25||strlen($password)<6) {
				$errors[] = "Password must be 6-25 characters long";
				return;
			} else if($portfolio == ""){
			    $errors[] ="You must have an active portfolio to join Connectd"; 
			    return;
			} else if($jobtitle == ""){
			    $errors[] ="Please select your current job title"; 
			    return;
			}else if($experience == ""){
			    $errors[] ="Please enter your experience"; 
			    return;
			}else if($bio == ""){
			    $errors[] ="Please write about yourself"; 
			    return;
			}else if(strlen($bio)<25) {
				$errors[] = "You're not going to sell yourself without a decent bio!";
				return;
			}
		}
	}