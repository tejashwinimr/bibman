<?php
try {
	$user = 'root';
	$pass = '';
    $db = new PDO('mysql:host=localhost;dbname=bibilographymanager', $user, $pass);
    
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>