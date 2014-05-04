<?php
    require("../../config.php");
    require(ROOT_PATH . "core/init.php"); 

	$getSkills = $freelancers->getFreelancerSkills($sessionUserID);
	$skills = array();

	foreach($getSkills as $skill) {
		$skills[] = $skill['skill'];
	}

	header('Content-type: application/json');
	echo json_encode($skills);