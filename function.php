<?php
include("config.php");
function register($uname, $email, $pass) {
	global $db;
	$hash = hash('md5', $pass);
	$insert = $db -> prepare("INSERT INTO User ( username, email_id, Password) VALUES(?,?,?)");
	$insert -> bindParam(1, $uname);
	$insert -> bindParam(2, $email);
	$insert -> bindParam(3, $hash);
	$insert -> execute();
	if($insert) {
		return true;
	}
}
/*function isLoggedIn() {
	return (isset($_SESSION['user_id']) && $_SESSION['logged_in'] == true);
}
function logIn($username, $password) {
	session_start();
	global $db;
	$q = $db -> prepare("SELECT u.id, u.Password FROM User u WHERE u.username = ?");
	$q -> bindParam(1, $username);
	$q -> execute();
	$result = $q -> fetch(PDO::FETCH_ASSOC);
	//alert('here');
	if(validate($password, $result['Password'])) {
		$_SESSION['uname'] = $username;
		$_SESSION['logged_in'] = true;
		$_SESSION['logout'] = false;
		$_SESSION['user_id'] = $result['id'];
		return true;
	}
	return $result;
}
function newfolder($folder) {
	session_start();
	global $db;
	$insert = $db -> prepare("INSERT INTO folders (user_id, name) VALUES (?, ?)");
	$insert -> bindParam(1, $_SESSION['user_id']);
	$insert -> bindParam(2, $folder);
	$insert -> execute();
	if($insert) {
		return true;
	}
}
function delFolder($delfolder) {
	session_start();
	global $db;
	$delete = $db -> prepare("DELETE FROM folders WHERE user_id=? AND name=?");
	$delete -> bindParam(1, $_SESSION['user_id']);
	$delete -> bindParam(2, $delfolder);
	$delete -> execute();
	if($delete) {
		return true;
	}
}
function addRefToFolder($pickfolder, $idarray) {
	session_start();
	global $db;
	foreach ($idarray as &$idref) {
	$insert = $db -> prepare("INSERT INTO folders (user_id, name, ref_id) VALUES (?, ?, ?)");
	$insert -> bindParam(1, $_SESSION['user_id']);
	$insert -> bindParam(2, $pickfolder);
	$insert -> bindParam(3, $idref);
	$insert -> execute();
	if ($pickfolder == 'trash') {
		$deleteFromOther = $db -> prepare("DELETE FROM folders WHERE user_id=? AND name != 'trash' AND ref_id=?");
		$deleteFromOther -> bindParam(1, $_SESSION['user_id']);
		$deleteFromOther -> bindParam(2, $idref);
		$deleteFromOther -> execute();
	}
	if ($pickfolder != 'trash'){
		$deleteFromOther = $db -> prepare("DELETE FROM folders WHERE user_id=? AND name = 'trash' AND ref_id=?");
		$deleteFromOther -> bindParam(1, $_SESSION['user_id']);
		$deleteFromOther -> bindParam(2, $idref);
		$deleteFromOther -> execute();
	}
	}
	if($insert) {
		return true;
	}
}
function delRef($delRef) {
	session_start();
	global $db;
	$inserttrash = $db -> prepare("INSERT INTO folders (user_id, name, ref_id) VALUES (?, 'trash', ?)");
	$inserttrash -> bindParam(1, $_SESSION['user_id']);
	$inserttrash -> bindParam(2, $delRef);
	$inserttrash -> execute();
	$deleteFromOther = $db -> prepare("DELETE FROM folders WHERE user_id=? AND name != 'trash' AND ref_id=?");
	$deleteFromOther -> bindParam(1, $_SESSION['user_id']);
	$deleteFromOther -> bindParam(2, $delRef);
	$deleteFromOther -> execute();
	
	if($inserttrash && $deleteFromOther) {
		return true;
	}
}
// changing password
function changePassword($current_password, $new_password) {
	session_start();
	global $db;
	/*$q = $db -> prepare("SELECT u.id, u.Password FROM User u WHERE u.username = ?");
	$q -> bindParam(1, $_SESSION['uname']);
	$q -> execute();
	$result = $q -> fetch(PDO::FETCH_ASSOC);
	//alert('here');
	//echo $result['Password']." ";
	$thisHash =  hash('md5', $current_password);
	echo $thisHash;*/
	/*if(hash('md5', $current_password), $result['Password']) {
		echo "herer !";
	}*/ /*
	$query = $db -> prepare("UPDATE User SET Password = :newPassword WHERE id = :id AND Password = :currentPassword");
	$query->bindParam(':newPassword', hash('md5', $new_password));
	$query->bindParam(':id', $_SESSION['user_id']);
    $query->bindParam(':currentPassword', hash('md5', $current_password));
    $query->execute();
	$count = $query->rowCount();
	if($count ==0){
    return false;
	}
	else{
    return true;
	}
}
function validate($plain, $hash) {
	$thisHash = hash('md5', $plain);
	//echo "this ".$thisHash;
	//echo "<br>that ".$hash;
	return $thisHash === $hash;
}
function logout() {
	session_start();
	$_SESSION['logged_in'] = false;
	$_SESSION = array();
	session_destroy();
	//window.location.replace("login.php");
	//document.location = "login.php";
	
	if(isset($_SESSION['logout']) && !empty($_SESSION['logout'])) {
   	
	return true;
	}
	return false;
}
function PopupAdd($title, $author, $dateCreated, $datePublished, $volume, $abstract, $pages) {
	session_start();
	global $db;
	$q = $db -> prepare("INSERT INTO refs (title, author, date_added, date_published, volume, pages, user_id, abstract) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
	$q -> bindParam(1, $title);
	$q -> bindParam(2, $author);
	$q -> bindParam(3, $dateCreated);
	$q -> bindParam(4, $datePublished);
	$q -> bindParam(5, $volume);
	$q -> bindParam(6, $pages);
	$q -> bindParam(7, $_SESSION['user_id']);
	$q -> bindParam(8, $abstract);
	$q -> execute();
	//alert($q);
	$count = $q->rowCount();
	if($count ==0){
    return false;
	}
	else{
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
*/