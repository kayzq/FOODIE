<?php

include("studconnection.php");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

//$_POST ambil nama <input>
$MatricNo = mysqli_real_escape_string($conn,$_POST['MatricNo']);
$password = mysqli_real_escape_string($conn,$_POST['password']);


$sql = "SELECT * FROM students s 
		where MatricNo = '$MatricNo'
		and password = '$password'";


		
//echo &sql;
$qry = mysqli_query($conn, $sql);
$row = mysqli_num_rows($qry);

		if($row > 0)
		{
			$r = mysqli_fetch_assoc($qry);
			
			//$_SESSION store information (in variables) to be used across multiple pages
			
			session_start();
			
			$_SESSION['userlogged'] = 1;
			$_SESSION['MatricNo'] = $MatricNo;
			$_SESSION['password'] = $password;
			$_SESSION['studIcNo'] = $r['studIcNo'];
			$_SESSION['studID'] = $r['studID'];
			$_SESSION['studGender'] = $r['studGender'];
			$_SESSION['studName'] = $r['studName'];
			
			
			//use when stud order product
			$_SESSION['orderID'] = ""; //to create orderID
			$_SESSION['logoutPermission'] = 1; //when stud select prod and that prod have in cart, this will prevent them to log out to the system [0=No 1=Yes]
			$_SESSION['order4Receipt'] = ""; //after checkout, orderID will be new but the orderID that has been ordered before will be save in this $_SESSION
			
			
			header("Location:home.php");
		
			}
			
		
		else
		{
			echo
			"<script language='javascript'>
				alert('Student does not exist.');
				window.location='index.php';
			</script>";
		}

?>