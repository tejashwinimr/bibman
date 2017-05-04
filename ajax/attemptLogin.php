<?php
include("../inc/functions.php");
//echo $_POST['email'];

echo login($_POST['email'], $_POST['password']) ? 'true' : 'false';