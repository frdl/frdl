<?php
// EDIT THIS --> move config out of webroot!
return  __DIR__.\DIRECTORY_SEPARATOR.'..'.\DIRECTORY_SEPARATOR.'..'.\DIRECTORY_SEPARATOR.'mywebsite-config.php';

return [
	'core'=>[
		   'facades_enabled'=> false,
		
		],
	'db' =>
[
	// [required]
	'type' => 'mysql',
	'host' => 'localhost',
	'database' => 'car_rental',
	'username' => '***',
	'password' => '***',
 
	// [optional]
//	'charset' => 'utf8mb4',
//	'collation' => 'utf8mb4_general_ci',
	'port' => 3306,
 
	// [optional] The table prefix. All table names will be prefixed as PREFIX_table.
	'prefix' => '',
 /*
	// [optional] To enable logging. It is disabled by default for better performance.
	'logging' => true,
 
	// [optional]
	// Error mode
	// Error handling strategies when the error has occurred.
	// PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
	// Read more from https://www.php.net/manual/en/pdo.error-handling.php.
	'error' => PDO::ERRMODE_SILENT,
 
	// [optional]
	// The driver_option for connection.
	// Read more from http://www.php.net/manual/en/pdo.setattribute.php.
	'option' => [
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	],
 
	// [optional] Medoo will execute those commands after the database is connected.
	'command' => [
		'SET NAMES utf8'
	],
	*/
],
	
];