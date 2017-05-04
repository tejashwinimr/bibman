<?php
	require 'config.php';
	include("setup.php");
	session_destroy();
	header('Location:login.php');
	exit();
?>
