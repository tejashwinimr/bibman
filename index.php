<?php
	require 'config.php';
	if(empty($_SESSION['name']))
		header('Location:login.php');


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

  if(!isset($result['id'])) { //Don't create the trash folder if it already exists for this user

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

  if(!isset($result['id'])) { //Don't create the trash folder if it already exists for this user

    $insert = $db -> prepare("INSERT INTO folders(name, user_id) VALUES (?, ?)");
    $insert -> bindValue(1,'unfiled');
    $insert -> bindParam(2, $user_id);
    $insert -> execute();

  }

  return;

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

            <?php
				        if(isset($errMsg)){
					                       echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				              }
			         ?>
                <h3> <p>Bibiliography Manager<p></h3>
            </div> 


            <h4>
            Welcome <?php echo $_SESSION['name']; ?> <br>
                </h4>
			 
            <div id="menu">
                <ul class="navigation">
                    <li><a href="#home" class="selected menu_01">Home</a></li>
                    <li><a href="#about" class="menu_02">Change Library</a></li>
                    <li><a href="#services" class="menu_03">Search Library</a></li>
                    <li><a href="#gallery" class="menu_04">Create New Library</a></li>
                    <li id="redirect"><a href="update.php" >Setting</a></li>
                    
                    
                </ul>
            </div>
		</div> <!-- end of sidebar -->


    <ul align="right"><a href="logout.php" class="menu_05">Logout</a></ul> 
     <!-- <ul align="right" >  <select id="folders" class="form-control">
                                  <option value="" default> Hi <?php echo $_SESSION['name']; ?></option>
                                  <option value="logout" default><a location.href="logout.php">Logout</a></option>
                                  <option value="setting"><a "location.href='update.php'">Setting</a></option>
                                 
                              </select>
                              </ul>-->

        <div id="content">
        <div class="content_section">

               <div class="scroll">
                  <div class="scrollContainer">
                    <div class="panel" id="home">
                    

              
                            <h2>Dashboard</h2>

                             <select id="folders" class="form-control">
                                  <option value="" default>Select one</option>
                                  <option value="all" default>All</option>
                                  <option value="trash">trash</option>
                                  <option value="unfiled">unfiled</option>
                              </select>
                              <div class="cleaner_h20"></div>

                            <!--<style>
                            table, th, td {
                                             border: 1px solid black;
                                              border-collapse: collapse;
                                              padding: 5px;
                                               text-align: left;   
                                            }
              

                              </style> -->
                               
                            	<thead>
                           

                  <div id="table_wrapper">
                            	
								<table style="width:50%" class ="tab">
 								  <tr >
   									 <th>Title</th>
    								 <th>Author</th>
    								 <th>Date Added</th>
    								 <th>Date Published</th>
    								 <th>Volume</th>
    								 <th>Abstract</th>
    								 <th>Pages</th>
  								</tr>
								</thead>
	<tbody>
  	
    
    

  <?php
    

     if(isset($_GET['folder']) && $_GET['folder'] != 'all') {
        $q = $db -> prepare("SELECT r.* FROM refes r INNER JOIN folders f ON r.user_id = f.user_id 
            WHERE r.user_id = ? AND f.name = ? AND r.user_id = f.user_id AND r.id = f.ref_id");

        $q -> bindParam(1, $_SESSION['id']);
        $q -> bindParam(2, $_GET['folder']);
        $q -> execute();
        $results = $q -> fetchAll(PDO::FETCH_ASSOC);
        
    } else {

      $q = $db -> prepare("SELECT r.* FROM refes r WHERE r.user_id = ?");
      $q -> bindParam(1, $_SESSION['id']);
      $q -> execute();
      $results = $q -> fetchAll(PDO::FETCH_ASSOC);

     // var_dump($results);

        }


  		foreach($results as $row) { ?>
  		<tr>
  			<td><?=$row['title']?></td>
		  	<td><?=$row['author']?></td>
		  	<td><?=$row['date_added']?></td>
		  	<td><?=$row['date_published']?></td>
		  	<td><?=$row['volume']?></td>
		  	<td><?=$row['abstract']?></td>
		  	<td><?=$row['pages']?></td>
		 </tr>

  		 <?php } ?>
  		 </tbody>
  	</table>


  <form action="" method="post">	
<div class="cleaner_h30"></div>

    <button id="modal-button" type="button" class="btn btn-info btn-lg">Delete</button>
    
    
</form>

                            
                           
  

  <script type="text/javascript">
    $('#folders').change( function (e) {
        e.preventDefault();
        var folder = $(this).val();
        window.location.href = "index.php?folder="+folder;
        
    });
  </script>
  <script type="text/javascript">
    
    $('#redirect').click( function (e) {
      window.location.href = "update.php"; 
    });
  </script>
  	
                            </div>
                            </div>
                            </div>
                            
                            

</body>
</html>
