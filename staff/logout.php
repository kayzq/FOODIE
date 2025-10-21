<?php

session_start();
include("studconnection.php");

if(!isset($_SESSION['logoutPermission']) || $_SESSION['logoutPermission'] == 0) //No
{
	echo"<script language='javascript'>
	alert('You must cancel or checkout your order before log out!');window.location='history.back()';</script>";
}
else
{
	session_start();
	session_unset();
	session_destroy();
	header("Location: /FOODIE/landing-page/index.html");
}
?>