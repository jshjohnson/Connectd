<?php

	// // Local environment

	// define("BASE_URL","/Connectd/htdocs/");
	// define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"] . "/Connectd/htdocs/");

	// Staging environment
	define("BASE_URL","http://dev.connectd.io");
	define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"] . "domains/dev.connectd.io/current/");

	// // Production environment
	// define("BASE_URL","http://connectd.io");
	// define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"] . "domains/connectd.io/current/");

	define("DB_HOST", "localhost");
	define("DB_NAME", "connectdDB");
	define("DB_PORT", "8888");
	define("DB_USER", "jshjohnson");
	define("DB_PASS", "kerching27");