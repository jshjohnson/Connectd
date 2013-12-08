<?php
	// Strip data from a malicious 
	function clean_string($db_server = null, $string){
		$string = trim($string);
		$string = utf8_decode($string);
		$string = str_replace("#", "&#35", $string);
		$string = str_replace("%", "&#37", $string);
			if (mysqli_real_escape_string($db_server, $string)) {
				$string = mysqli_real_escape_string($db_server, $string);
			}
			if (get_magic_quotes_gpc()) {
				$string = stripslashes($string);
			}
		return htmlentities($string);
	}
	
	//Encrypt password
	function salt($string){ 
		$salt1 = 'a9*g4qwgrsht';
		$salt2 = 'bu59304fh8ura0';
		$salted = md5("$salt1$string$salt2");
		return $salted;
	}
?>