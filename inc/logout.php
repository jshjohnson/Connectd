<?php 
	session_start();
      // Unset all of the session variables.
      $_SESSION = array();
      // Destroy the session
      session_destroy();
      header('Location: ../sign-in.php?status=logged');
      // Print out the confirmation page
?>