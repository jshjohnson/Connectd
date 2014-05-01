<?php
	require_once("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();

	$pageTitle = "Change Password";
	$pageType = "Page";
	$section = "Blue";

	$currentPassword = $_POST['current_password'];
	$newPassword = $_POST['new_password'];
	$repeatNewPassword = $_POST['repeat_new_password'];

	if(empty($_POST) === false) {
	   
	    if(empty($currentPassword) || empty($newPassword) || empty($repeatNewPassword)){

	        $errors[] = 'All fields are required';

	    }else if($bcrypt->verify($currentPassword, $sessionUser['password']) === true) {

	        if (trim($newPassword) != trim($repeatNewPassword)) {
	            $errors[] = 'Your new passwords do not match';
	        } else if (strlen($newPassword) < 6) { 
	            $errors[] = 'Your password must be at least 6 characters';
	        } else if (strlen($newPassword) >18){
	            $errors[] = 'Your password cannot be more than 18 characters long';
	        } 

	    } else {
	        $errors[] = 'Your current password is incorrect';
	    }
	}

    if (empty($_POST) === false && empty($errors) === true) {
        $users->changePassword($sessionUserID, $newPassword);
        header('Location: change-password.php?success');
    } 

    include(ROOT_PATH . "includes/header.inc.php");
    include(ROOT_PATH . "views/settings/change-password.html"); 
    include(ROOT_PATH . "includes/footer.inc.php");
?>