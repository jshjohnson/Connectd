<?php
include_once("inc/errors.php");  
//Form Vaidation
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$submit = trim($_POST['submit']);

if ($submit=='Sign In'){
			
    if($email == ""){
        $message="Please enter your email"; 
    }else if($password == ""){
        $message="Please enter your password"; 
    }else{
		session_start(); 
		require_once("inc/db_connect.php");

		mysqli_select_db($db_server, $db_database) or die("Couldn't find db");

		$email = clean_string($db_server, $email); 
		$password = clean_string($db_server, $password);
		$query = "SELECT designers.email, designers.password FROM connectdDB.designers WHERE designers.email='$email' UNION SELECT developers.email, developers.password FROM connectdDB.developers WHERE developers.email='$email' UNION SELECT employers.email, employers.password FROM connectdDB.employers WHERE employers.email='$email'"; 
		$result = mysqli_query($db_server, $query);
		
		if($row = mysqli_fetch_array($result)){
			$db_email = $row['email'];
			$db_password = $row['password'];
			$DBID = $row['ID'];
				if($email==$db_email&&salt($password)==$db_password){
					$_SESSION['email']=$email;
					$_SESSION['userID']=$DBID;
					$_SESSION['logged']="logged";
					header('Location: dashboard/');
				}else{
	              $message = "Incorrect password!";
	            }
	    }else{
	        $message = "That user does not exist!" . " Please try again";
	   } 
	   mysqli_free_result($result);	
	   require_once("inc/db_close.php");
	}
}
?>