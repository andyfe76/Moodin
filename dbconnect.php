<?php
$server="";//database server
$username=""; //database username
$password="";     //database password
$dbname="";//database name
mysql_connect($server, $username, $password) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
$admin_user="";
$admin_pass="";
?>
