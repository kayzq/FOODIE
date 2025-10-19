<?php

$dbuser = "root";
$dbpass ="";
$dbhost = "localhost";
$dbname = "foodie";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname,3306);

if(!isset($conn))
	echo "connection is not ok";
else


?>