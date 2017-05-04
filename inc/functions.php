<?php
include("connect.php");

function isLoggedIn() {
	return (isset($_SESSION['user_id']) && $_SESSION['logged_in'] == true);

}

function logIn($uname, $pass) {
	session_start();
	global $db;
	$q = $db -> prepare("SELECT u.id, u.hash FROM users u WHERE u.uname = ?");
	$q -> bindParam(1, $uname);
	$q -> execute();
	$result = $q -> fetch(PDO::FETCH_ASSOC);

	if(validate($pass, $result['hash'])) {
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $result['id'];
		return true;
	}
	return $result;

}

function logout() {

	$_SESSION['logged_in'] = false;

	$_SESSION = array();
	session_destroy();
}

function validate($plain, $hash) {

	$thisHash = hash('md5', $plain);
	//echo "this ".$thisHash;
	//echo "<br>that ".$hash;
	return $thisHash === $hash;
}

function register($uname, $pass) {
	global $db;

	$hash = hash('md5', $pass);

	$insert = $db -> prepare("INSERT INTO users (uname,first_name, hash) VALUES(?,?,?)");
	$insert -> bindParam(1, $uname);
	$insert -> bindParam(2, $hash);
	$insert -> bindParam(3, $hash);
	$insert -> execute();

	if($insert) {
		return true;
	}
}


function create_trash($user_id) {

	global $db;

	$q = $db -> prepare("CREATE TABLE IF NOT EXISTS folders(
	  	id INT(11) NOT NULL AUTO_INCREMENT,
	  	name VARCHAR(45) DEFAULT NULL,
	  	user_id INT(10),
	  	PRIMARY KEY (id))");

	$check_for_trash = $db -> prepare("SELECT f.id FROM folders f WHERE f.name = ? AND f.user_id = ? LIMIT 1");
	$check_for_trash -> bindValue(1, 'trash');
	$check_for_trash -> bindParam(2, $user_id);
	$check_for_trash -> execute();
	$result = $check_for_trash -> fetch(PDO::FETCH_ASSOC);

	if(!isset($result['id'])) {	//Don't create the trash folder if it already exists for this user

		$insert = $db -> prepare("INSERT INTO folders(name, user_id) VALUES (?, ?)");
		$insert -> bindValue(1,'trash');
		$insert -> bindParam(2, $user_id);
		$insert -> execute();

	}

	$check_for_unfiled = $db -> prepare("SELECT f.id FROM folders f WHERE f.name = ? AND f.user_id = ? LIMIT 1");
	$check_for_unfiled -> bindValue(1, 'unfiled');
	$check_for_unfiled -> bindParam(2, $user_id);
	$check_for_unfiled -> execute();
	$result = $check_for_unfiled -> fetch(PDO::FETCH_ASSOC);

	if(!isset($result['id'])) {	//Don't create the trash folder if it already exists for this user

		$insert = $db -> prepare("INSERT INTO folders(name, user_id) VALUES (?, ?)");
		$insert -> bindValue(1,'unfiled');
		$insert -> bindParam(2, $user_id);
		$insert -> execute();

	}

	return;

}

