<?php
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$remember = trim($_POST['remember']);
	$submit = trim($_POST['submit']);

	$year = time() + 31536000;

	if ($submit=='Sign In'){
				
	    if($email == ""){
	        $message="Please enter your email"; 
	    }else if($password == ""){
	        $message="Please enter your password"; 
	    }else{

	    	//Start session
			session_start(); 
			require_once("inc/db_connect.php");

			$email = clean_string($db, $email); 
			$password = clean_string($db, $password);

			try {
				$results = $db->prepare("SELECT designers.id, designers.firstname, designers.lastname, designers.email, designers.password FROM connectdDB.designers WHERE designers.email = ? UNION SELECT developers.id, developers.firstname, developers.lastname, developers.email, developers.password FROM connectdDB.developers WHERE developers.email = ? UNION SELECT employers.id, employers.firstname, employers.lastname, employers.email, employers.password FROM connectdDB.employers WHERE employers.email = ?");
				$results->bindParam(1, $email);
				$results->bindParam(2, $email);
				$results->bindParam(3, $email);
				$results->execute();

				$total = $results->rowCount();
				$row = $results->fetch();
			
			} catch (Exception $e) {
				$message = "Damn. Data could not be retrieved.";
				exit;
			}

			if($total > 0){

				$db_name = $row['firstname'] . ' ' . $row['lastname'];
				$db_email = $row['email'];
				$db_password = $row['password'];
				$db_id = $row['id'];

					if($email==$db_email&&salt($password)==$db_password){
						$_SESSION['username'] = $db_name;
						$_SESSION['email']=$email;
						$_SESSION['userID']=$db_id;
						$_SESSION['logged']="logged";

						// If remember has been checked, set a cookie
						if($remember) {
							setcookie('remember_me', $email, $year);
						}
						// If remember has not been checked, kill off any past cookies
						elseif(!$remember) {
							if(isset($_COOKIE['remember_me'])) {
								$past = time() - 100;
								setcookie(remember_me, gone, $past);
							}
						}

						header('Location: dashboard/');
					}else{
		              $message = "Incorrect password!";
		            }
		    }else{
		        $message = "That user does not exist!" . " Please try again";
		   } 
		}
	}