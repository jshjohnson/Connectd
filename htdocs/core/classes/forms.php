<?php 
	class Forms {
		
		// Properties
	 	
		private $db;

		public function __construct($database) {
			$this->db = $database;
		    $this->mail = new PHPMailer();
		    $this->users = new Users($this->db);
		}
		
		/**
		 * Prevent form hijacking
		 *
		 * @param  void
		 * @return void
		 */ 
		public function hijackPrevention() {
			foreach( $_POST as $value ){
	            if( stripos($value,'Content-Type:') !== FALSE ){
	                $errors[] = "Hmmmm. Are you a robot? Try again.";
	            }
	        }
		}

		/**
		 * If a user has checked "Remember me", set a cookie
		 *
		 * @param  
		 * @return boolean
		 */ 
		public function rememberMe($remember, $email, $year) {
			if($remember) {
				setcookie('remember_me', $email, $year);
			} elseif(!$remember) {
				if(isset($_COOKIE['remember_me'])) {
					$past = time() - 100;
					setcookie(remember_me, gone, $past);
				}
			}
		}
		
	 	/**
		 * Checks if there is any file in the directory with the same name as the file that you want to put there. 
		 * If there is a duplicate, a number will be appended to the fule
		 *
		 * @param string $path
		 * @param string $filename
		 * @return void
		 */ 
		public function fileNewPath($path, $filename){
			if ($pos = strrpos($filename, '.')) {
				$name = substr($filename, 0, $pos);
				$ext = substr($filename, $pos);
			} else {
				$name = $filename;
			}

			$newpath = $path.'/'.$filename;
			$newname = $filename;
			$counter = 0;

			while (file_exists($newpath)) {
				$newname = $name .'_'. $counter . $ext;
				$newpath = $path.'/'.$newname;
				$counter++;
			}

			return $newpath;
		}

		public function validateFreelancer($firstName, $lastName, $email, $password, $repeatPassword, $portfolio, $jobTitle, $experience, $bio) {

			$r1='/[A-Z]/';  // Test for an uppercase character
			$r2='/[a-z]/';  // Test for a lowercase character
			$r3='/[0-9]/';  // Test for a number

			if($firstName == ""){
			    $errors[] ="Please enter your first name"; 
			}else if($lastName == ""){
			    $errors[] ="Please enter your last name"; 
			}else if($email == ""){
			    $errors[] ="Please enter your email"; 
			}else if (!$this->mail->ValidateAddress($email)){
					$errors[] = "You must specify a valid email address.";
			}else if ($this->users->emailExists($email) === true) {
			    $errors[] = "Email already taken. Please try again.";
			}else if($password == ""){
			    $errors[] ="Please enter a password"; 
			}else if ($password!=$repeatPassword){ 
				$errors[] = "Both password fields must match";
			} else if(preg_match_all($r1,$password, $o)<1) {
				$errors[] = "Your password needs to contain at least one uppercase character";
			} else if(preg_match_all($r2,$password, $o)<1) {
				$errors[] = "Your password needs to contain at least one lowercase character";
			} else if(preg_match_all($r3,$password, $o)<1) {
				$errors[] = "Your password needs to contain at least one number";
			} else if (strlen($password)>25||strlen($password)<6) {
				$errors[] = "Password must be 6-25 characters long";
			} else if($portfolio == ""){
			    $errors[] ="You must have an active portfolio to join Connectd"; 
			} else if($jobTitle == ""){
			    $errors[] ="Please select your current job title"; 
			}else if($experience == ""){
			    $errors[] ="Please enter your experience"; 
			}else if($bio == ""){
			    $errors[] ="Please write about yourself"; 
			}else if(strlen($bio)<25) {
				$errors[] = "You're not going to sell yourself without a decent bio!";
			}
			return $errors;
		}

		public function validateEmployer($firstName, $lastName, $email, $password, $repeatPassword, $employerName, $employerType, $experience, $bio) {
			if($firstName == ""){
		        $errors[] ="Please enter your first name"; 
		    }else if($lastName == ""){
		        $errors[] ="Please enter your last name"; 
		    }else if($email == ""){
		        $errors[] ="Please enter your email"; 
		    }else if (!$this->mail->ValidateAddress($email)){
	   			 $errors[]  = "You must specify a valid email address.";
			}else if ($this->users->emailExists($email) === true) {
			    $errors[] = "Email already taken. Please try again.";
			}else if($password == ""){
		        $errors[] ="Please enter a password"; 
		    }else if ($password!=$repeatPassword){ 
				$errors[]  = "Both password fields must match";
			}else if(preg_match_all($r1,$password, $o)<1) {
				$errors[]  = "Your password needs to contain at least one uppercase character";
			}else if(preg_match_all($r2,$password, $o)<1) {
				$errors[]  = "Your password needs to contain at least one lowercase character";
			}else if(preg_match_all($r3,$password, $o)<1) {
				$errors[]  = "Your password needs to contain at least one number";
			}else if (strlen($password)>25||strlen($password)<6) {
				$errors[]  = "Password must be 6-25 characters long";
			}else if($employerName == ""){
		        $errors[]  = "Please enter your business name"; 
		    }else if($employerType == ""){
		        $errors[]  = "Please enter your business type"; 
		    }else if($experience == ""){
			    $errors[] ="Please enter your experience";
			}else if($bio == ""){
		        $errors[]  = "Please write about your business"; 
		    }else if(strlen($bio)<25) {
				$errors[]  = "Freelancers require a bit more information about your business!";
			}
			return $errors;
		}

		public function validateJob($jobTitle, $jobLocation, $jobName, $startDate, $budget, $category, $description){
	    	if($jobTitle == ""){
		        $errors[] = "Please enter a freelancer type"; 
		    }else if($jobLocation == ""){
		        $errors[] = "Please select whether you need an onsite or remote freelancer"; 
		    }else if($jobName == ""){
		        $errors[] = "Please enter a job title"; 
		    }else if($startDate == ""){
		        $errors[] = "Please enter a job deadline"; 
		    }else if($budget == ""){
		        $errors[] = "Please enter a minimum budget"; 
		    }else if($category == ""){
		        $errors[] = "Please enter a job category"; 
		    }else if($description == ""){
		        $errors[] = "Please enter a job description"; 
		    }
		    return $errors;
	    }
	}