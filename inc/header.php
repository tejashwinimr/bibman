<?php
session_start();

include("connect.php");
include("functions.php");

if(isset($_POST['logout'])) {
	logout();
}
if(isLoggedIn()) {
	create_trash($_SESSION['user_id']);
}
?>

<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Bibman - 1.1</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="icon" href="images/favicon.ico" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <script
			  src="https://code.jquery.com/jquery-3.2.1.js"
			  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
			  crossorigin="anonymous"></script>

        <script src="https://use.fontawesome.com/15554a26f7.js"></script>
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>

        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

        
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    </head>
    <body>

    
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <!-- <div class="navbar-header">
          

        </div> -->
        <div class="col-md-11">
        	<a class="navbar-brand pull-right" href="index.php">Home</a>
        </div>
        <div class="col-md-1">
         <?php
    		if(!isLoggedIn()) { ?>


		          <form id="login-form" class="navbar-form navbar-right" role="form">
		            <div class="form-group">
		              <input type="text" name="email" placeholder="Email" class="form-control">
		            </div>
		            <div class="form-group">
		              <input type="password" name="password" placeholder="Password" class="form-control">
		            </div>
		            <button type="submit" class="btn btn-success">Sign in</button>
		            <button type="reset" class="btn btn-primary reg"><i class="fa fa-exchange" aria-hidden="true"></i> Register/login</button>
		          </form>


		          <form id="reg-form" class="navbar-form navbar-right" role="form" style="display:none">
		            <div class="form-group">
		              <input type="text" name="email" placeholder="Email" class="form-control">
		            </div>
		            <div class="form-group">
		              <input type="text" name="first_name" placeholder="Name" class="form-control">
		            </div>
		            <div class="form-group">
		              <input type="password" name="password" placeholder="Password" class="form-control">
		            </div>
		            <button type="submit" class="btn btn-success">Register</button>
		            <button type="reset" class="btn btn-primary reg"><i class="fa fa-exchange" aria-hidden="true"></i> Register/login</button>
		          </form>
         <?php } else { ?>
         		<div id="navbar" class="navbar-collapse collapse">
		          	<form id="logout-form" class="navbar-form navbar-right" role="form" method="POST">
				        <input type="hidden" name="logout" value="true">
				        <button type="submit" id="logout" class="btn btn-danger">Sign Out</button>
			        </form>
		        </div>

		    </div>


		        



		        <?php } ?>
      </div>
    </nav>

    <div class="container">
    <?php 

    	?>

    <script type="text/javascript">
    //---------------------------------------------Send the ajax request
    	$('#login-form').submit( function (e){

			e.preventDefault();    		
    		$info = $(this).serializeArray();

			var request = $.ajax({
			  url: "ajax/attemptLogin.php",
			  method: "POST",
			  data: $info,
			  dataType: "html"
			});
			 
			request.done(function( msg ) {
			  if(msg == 'true') {
					location.reload();
				} else if(msg == 'false') {
					alert('The details you have entered are incorrect!');
				}
			});

			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			});
    	});

    	$('#reg-form').submit( function (e){

			e.preventDefault();    		
    		$info = $(this).serializeArray();
    		console.log($info);

			var request = $.ajax({
			  url: "ajax/attemptRegister.php",
			  method: "POST",
			  data: $info,
			  dataType: "html"
			});
			 
			request.done(function( msg ) {
				if(msg == 'true') {
					location.reload();
				} else if(msg == 'false') {
					alert('Ooops! Something went wrong!');
				}
			});
			 
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: " + textStatus );
			});
    	});


    </script>
    <script type="text/javascript">
    	$('.reg').click( function (e) {
    		e.preventDefault();
    		$('#login-form').slideToggle();
    		$('#reg-form').slideToggle();
    	});
    </script>



    