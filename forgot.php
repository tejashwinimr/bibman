<?php
	require 'config.php';

	if(isset($_POST['forgotpass'])) {
		$errMsg = '';

		// Getting data from FROM
		$username = $_POST['username'];

		if(empty($username))
			$errMsg = 'Please enter your Username to view your password.';

		if($errMsg == '') {
			try {
				$stmt = $db->prepare('SELECT password, username FROM users WHERE username = :username');
				$stmt->execute(array(
					':username' => $username
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if($username == $data['username']) {
					$viewpass = 'Your password is: ' . $data['password'] . '<br><a href="login.php">Login Now</a>';
				}
				else {
					$errMsg = 'Username  not matched.';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>

<html>
<head><title>Forgot Password</title></head>
	<style>
	html, body {
		margin: 1px;
		border: 0;
	}
	</style>
<body>
	<div align="center">
		<div style=" border: solid 1px #006D9C; " align="left">
			<?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?>
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Forgot Password</b></div>
			<?php
				if(isset($viewpass)){
					echo '<div style="color:#198E35;text-align:center;font-size:17px;margin-top:5px">'.$viewpass.'</div>';
				}
			?>
			<div style="margin: 15px">
				<form action="" method="post">
					<input type="text" name="secretpin" placeholder="Usrename" autocomplete="off" class="box"/><br /><br />
					<input type="submit" name='forgotpass' value="Check" class='submit'/><br />
				</form>
			</div>
		</div>
	</div>
</body>
</html>
