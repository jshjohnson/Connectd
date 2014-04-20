<?php 
	class Forms {
		
		// Methods
		
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