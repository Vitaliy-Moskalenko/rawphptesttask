<?php

	error_reporting( E_ALL );
	 
	// Database
	define('DB_PERSISTENCY', 'true');
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'testtaskdb');
	define('PDO_POLLS',   'mysql:host='.DB_SERVER.';dbname='.DB_DATABASE);	
