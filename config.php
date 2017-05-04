<?php
session_start();
// Define database
define('dbhost', 'eu-cdbr-azure-north-e.cloudapp.net');
define('dbuser', 'b70b4a47125fe9');
define('dbpass', '1a417050');
define('dbname', 'techlogdb');
// Connecting database
try {
	$db = new PDO("mysql:host=".dbhost."; dbname=".dbname, dbuser, dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo $e->getMessage();
}
?>


