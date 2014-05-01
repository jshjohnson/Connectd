<?php
    require("../../config.php");
    require(ROOT_PATH . "core/init.php"); 

    $email = $_GET['email'];
    
    $emailExists = $users->emailExists($email);

    if ($emailExists == true) {
        $response->result = true;
    } else {
        $response->result = false;
    }

    echo json_encode($response);