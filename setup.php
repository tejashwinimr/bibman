<?php
//include("inc/connect.php");
function setupTables() {
	global $db;
	//Set up the users table
	$createUsers = $db -> prepare("CREATE TABLE IF NOT EXISTS users(
		  	id INT(11) NOT NULL AUTO_INCREMENT,
		  	name VARCHAR(45) DEFAULT NULL
		  	username VARCHAR(45) DEFAULT NULL,
		  	password VARCHAR(45),
		  	PRIMARY KEY (id))");
	$createUsers -> execute();
	
	
	//Set up the references table
	$createRefs = $db -> prepare("CREATE TABLE IF NOT EXISTS refes(
		  						id INT(11) NOT NULL AUTO_INCREMENT,
		  						title VARCHAR(45) DEFAULT NULL,
		  						author VARCHAR(45) DEFAULT NULL,
		  						volume VARCHAR(45) DEFAULT NULL,
		  						abstract VARCHAR(300) DEFAULT NULL,
		  						pages INT(5) DEFAULT NULL,
		  						user_id INT(11),
		  						date_published DATE DEFAULT NULL,
		  						date_added DATE DEFAULT NULL,
		  						PRIMARY KEY (id))");
	$createRefs -> execute();
	
	//Set up the folders table
	$createFolders = $db -> prepare("CREATE TABLE IF NOT EXISTS folders2(
		  	id INT(11) NOT NULL AUTO_INCREMENT,
		  	name VARCHAR(45) DEFAULT NULL,
		  	user_id INT(10),
		  	PRIMARY KEY (id))");
	
	$createFolders -> execute();
}
setupTables();