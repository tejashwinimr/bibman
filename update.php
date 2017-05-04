<?php
	require 'config.php';
	if(empty($_SESSION['name']))
		header('Location: login.php');
	

	if(isset($_POST['update'])) {
		$errMsg = '';

		// Getting data from FROM
		$name = $_POST['username'];
		$password = $_POST['password'];
		$passwordVerify = $_POST['passwordVerify'];

		if($password != $passwordVerify)
			$errMsg = 'Password not matched.';

		if($errMsg == '') {
			try {
		      $sql = "UPDATE users SET  password = :password WHERE username = :username";
		      $stmt = $db->prepare($sql);                                  
		      $stmt->execute(array(
		        
		        //':secretpin' => $secretpin,
		        ':password' => $password,
		        ':username' => $_SESSION['username']
		      ));
		      header('Location: index.php');
						exit;
				}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}

	if(isset($_GET['action']) && $_GET['action'] == 'updated')
		$errMsg = 'Successfully updated. <a href="logout.php">Logout</a> and login to see update.';
?>



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
                    	
                            <h2>Update Password</h2>    
                            
                                                      
                            <p><em>Please enter the below details</em></p>	
                            <?php
								if(isset($errMsg)){
													echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
												}
									?>
                            
                   			<div class="col_380 float_l">
                            <div id="contact_form">

							<form action="" method="post">
							<input type="hidden" name="update"  /><br /><br />

							<label for="username">Username:</label>
							<input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" disabled autocomplete="off" class="box"/>
							<div class="cleaner_h10"></div>

					
							<label for="password">Password:</label>
							<input type="password" name="password" value="" class="box" /><br/><br />
							<div class="cleaner_h10"></div>
									
					
							<label for="password">ConfirmPassword:</label>
							<input type="password" name="passwordVerify" value="" class="box" /><br/><br />
							<div class="cleaner_h10"></div>

							<input type="submit" name='update' value="Update" class='submit'/>
							<div class="float_r">
							<input type="reset" name='cancel' value="Cancel" class="reset" onclick="location.href='index.php'" />
								
									
									
									
									
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
