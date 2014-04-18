<?php
    require("../../config.php");
    require(ROOT_PATH . "core/init.php"); 

    // $debug->showErrors();
    // get email passed via AJAX
    $email = $_GET['email'];
    
    $emailExists = $users->emailExists($email);

    if ($emailExists == true) {
        $response->result = true;
    } else {
        $response->result = false;
    }

   // echo json
    echo json_encode($response);