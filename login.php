<?php
	require 'config.php';

	if(isset($_POST['login'])) {

		$errMsg = '';

		// Get data from FORM
		$username = $_POST['username'];
		$password = $_POST['password'];
		//$id = $_POST['id'];

		if($username == '')
			$errMsg = 'Enter username';
		if($password == '')
			$errMsg = 'Enter password';
		/*

		function validate($plain, $hash) {

			$thisHash = hash('md5', $plain);
	
			return $thisHash === $hash;
		} */

		if($errMsg == '') {
			try {
			$stmt = $db->prepare('SELECT id, name, username, password FROM users WHERE username = :username');
				$stmt->execute(array(
					':username' => $username
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "User $username not found.";
				}
				else {
					if($password == $data['password']) {
						$_SESSION['name'] = $data['name'];
						$_SESSION['username'] = $data['username'];

						$_SESSION['id'] = $data['id'];
						header('Location: dashboard.php');
						exit;
					}
					else
						$errMsg = 'Hmm, that\'s not the right password. Please try again';
				}  

				/*session_start();
				
			global $db;
			$q = $db -> prepare("SELECT u.id, u.password FROM users u WHERE u.username = ?");
			$q -> bindParam(1, $username);
			$q -> execute();
			$result = $q -> fetch(PDO::FETCH_ASSOC);
			
			//if(validate($password, $result['password'])) {
			$_SESSION['logged_in'] = true;
			$_SESSION['user_id'] = $result['id'];
			//return true;
			header('Location:dashboard.php');
			exit();
	//}*/

			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}


		
	}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                    	
                            <h2>Login</h2>    
                            
                                                      
                            <p><em>Please login to continue</em></p>	
                            <?php
								if(isset($errMsg)){
													echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
												}
									?>
                            
                   			<div class="col_380 float_l">
                            <div id="contact_form">
							<form action="" method="post">
								<label for="username">Username:</label><input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" class="box"/><br /><br />
									<div class="cleaner_h10"></div>
									<label for="password">Password:</label><input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" class="box" /><br/><br />
									<div class="cleaner_h10"></div>
									
									<input type="submit" name='login' value="Login" class='submit'/>
									
									<div class="float_r">
									<input type="reset" name='register' value="Register" class="reset" onclick="location.href='register.php'" />
									<div class="cleaner_h10"></div>
									<div class="float_r">
									<a href="forgot.php">Forgot Password</a>
									</div>
									
									
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</body>
</html>
