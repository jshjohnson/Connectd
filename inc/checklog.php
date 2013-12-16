<?php 
	//Check if user is logged in, if not redirect them to the homepage
	session_start();
      if (!isset($_SESSION['logged'])){
      $_SESSION = array();
      session_destroy();
      header("Location:" . BASE_URL . "sign-in.php");
     } 
?>
