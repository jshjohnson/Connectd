<?php
    require("../../config.php");
    require(ROOT_PATH . "core/init.php"); 

    // get email passed via AJAX
    if (isset($_GET['password'])) {
        $password = $_GET['password'];
    }
   

    $r1='/[A-Z]/';  // Test for an uppercase character
    $r2='/[a-z]/';  // Test for a lowercase character
    $r3='/[0-9]/';  // Test for a number

    if(preg_match_all($r1,$password, $o)<1) {
        $response->result = false;
    } else if(preg_match_all($r2,$password, $o)<1) {
        $response->result = false;
    } else if(preg_match_all($r3,$password, $o)<1) {
        $response->result = false;
    } else {
        $response->result = true;
    }

   // echo json
    echo json_encode($response);