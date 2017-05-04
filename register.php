<?php
	require 'config.php';
	//include("setup.php");

	if(isset($_POST['register'])) {
		$errMsg = '';

		// Get data from FROM
		$createUsers = $db -> prepare("CREATE TABLE IF NOT EXISTS users1(
		  	id INT NOT NULL AUTO_INCREMENT,
		  	name VARCHAR(45) DEFAULT NULL
		  	username VARCHAR(45) DEFAULT NULL,
		  	password VARCHAR(45),
		  	PRIMARY KEY (id))");
			$createUsers -> execute();

		$name = $_POST['name'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		//$hash = $_POST['hash'];
		
		
		if($name == '')
			$errMsg = 'Enter name';
		if($username == '')
			$errMsg = 'Enter username';
		if($password == '')
			$errMsg = 'Enter password';
	
		if($errMsg == ''){
			try {
				
				//header('Location: register.php?action=joined');
				//exit;

				global $db;

			$hash = hash('md5', $password);

			//Email Validation 
			if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
     			
     			 $errMsg = 'Invaild email, Enter a valid email';

    			}
    			else
    			{
    				//adding regitseration deatils to database. 
    		

			$insert = $db -> prepare("INSERT INTO users1 (name, username, password) VALUES(?,?,?)");
			$insert -> bindParam(1, $name);
			$insert -> bindParam(2, $username);
			$insert -> bindParam(3, $password);
			$insert -> execute();
			header('Location: login.php'); //redirecting to Login page 
			//header('Location:register.php?action=joined');
			exit;

			}
		}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

	if(isset($_GET['action']) && $_GET['action'] == 'joined') {
		$errMsg = 'Registration successfull. Now you can <a href="login.php">login</a>';
	}
?>

<<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
Guitar Template is provided by www.tooplate.com
-->
<title>Bibiliography Manager</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/tooplate_style.css" rel="stylesheet" type="text/css" />
<link href="css/coda-slider.css" rel="stylesheet" type="text/css" charset="utf-8" />

<script src="js/jquery-1.2.6.js" type="text/javascript"></script>
<script src="js/jquery.scrollTo-1.3.3.js" type="text/javascript"></script>
<script src="js/jquery.localscroll-1.2.5.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.serialScroll-1.2.1.js" type="text/javascript" charset="utf-8"></script>
<script src="js/coda-slider.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.easing.1.3.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>
	
    <div id="slider">
    <div id="tooplate_wrapper">
	
	<div id="tooplate_sidebar">
        
            <div id="header">
                <p>Bibiliography Manager<p>
            </div>    
			
    </div>
          
        <div id="content" >
            <div class="scroll">
                <div class="scrollContainer">
                
                    <div class="panel" id="home">
                    	
                            <h2>Registration Form</h2>    
                            
                                                      
                            <p><em>Please fill this form to register yourself.</em></p>	
                            <?php
								if(isset($errMsg)){
													echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
													}
							?>
                            
                   			<div class="col_380 float_l">
                            <div id="contact_form">
				<form action="" method="post">
				<input type="text" name="name" placeholder="Name" value="<?php if(isset($_POST['name'])) echo $_POST['name'] ?>" autocomplete="off" class="box" /><br /><br />
					
					<input type="text" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" class="box" id='txtEmail'/><br /><br />
					<input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" class="box" /><br/><br />
					
					<input type="submit" name='register' value="Register" class='submit' onclick='Javascript:checkEmail();'/><br />
					<div class="cleaner_h10"></div>
					<div class="float_r">
									<input type="reset" name='register' value="Cancel" class="reset" onclick="location.href='login.php'" />
				</form>
			</div>
		</div>
	</div>
	</div>
</body>
<!-- Client side validation
	<script src="js/jquery.validation/jquery.validate.js"></script>
    <script src="js/jquery.validation/additional-methods.js"></script>
    <script language="javascript">

function checkEmail() {

    var email = document.getElementById('txtEmail');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
    alert('Please provide a valid email address');
    window.location.href = "register.php"; 
    email.focus;
    return false;
 }

}</script>
-->
</html>
