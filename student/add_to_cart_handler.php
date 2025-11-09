<?php

session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
}


$prodID1 = $_GET['prodID']; // get id through query string

$qry = mysqli_query($conn,"SELECT * FROM products p INNER JOIN prodtypes pt ON p.typeID = pt.typeID WHERE prodID='$prodID1'"); // select query

$data = mysqli_fetch_array($qry); // fetch data



if (isset($_POST['select']))
{
	$orderID = $_SESSION['orderID'];
	
	$detailID = $_POST['detailID'];
	$prodID = $_POST['prodID'];
	$studID = $_POST['studID'];
	$prodName = $_POST['prodName'];

	function checkOrderID($conn,$orderID)
	{
		$found = false;
		$sql = "SELECT orderID FROM orders WHERE orderID='".$orderID."'";
		$qry=mysqli_query($conn,$sql);
		$row=mysqli_num_rows($qry);
		
		if($row > 0)
		{
			$found = true;
		}
		return $found;
	}
	
	function checkDetailID($conn,$detailID,$orderID)
	{
		$found = false;
		$sql = "SELECT detailID FROM orderdetails WHERE detailID='".$detailID."' AND orderID = '".$orderID."'";
		$qry=mysqli_query($conn,$sql);
		$row=mysqli_num_rows($qry);
		
		if($row > 0)
		{
			$found = true;
		}
		return $found;
	}
	
	function checkProdID($conn,$prodID,$orderID)
	{
		$found = false;
		$sql = "SELECT prodID FROM orderdetails WHERE prodID='".$prodID."' AND orderID = '".$orderID."'";
		$qry=mysqli_query($conn,$sql);
		$row=mysqli_num_rows($qry);
		
		if($row > 0)
		{
			$found = true;
		}
		return $found;
	}


	if(checkOrderID($conn, $orderID) == false) //new order
	{
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$todayDate = date("Y-m-d"); //2020-11-03
		
		$insertOrders = "INSERT INTO orders(orderID,orderDate,deliveryDate,dormLevel,dormNo,buildingID,studID,adminID)
						values('$orderID','$todayDate','$todayDate','1','1','BD001', $studID,'ADM01')";
		
		if (mysqli_query($conn, $insertOrders)) 
		{
			if(checkDetailID($conn, $detailID, $orderID) == false) //don't have same detailID
			{
				$insertOrderDetails = "INSERT INTO orderdetails(detailID,quantity,orderID,prodID)values('$detailID',1,'$orderID','$prodID')";
					
				if (mysqli_query($conn, $insertOrderDetails)) 
				{
					$_SESSION['logoutPermission'] = 0; //no log out
					
					echo "<script language='javascript'>
					alert('Product on new order has been add into the cart.');window.location='search.php';</script>";
				} 
				else 
				{
					echo "Error: " . $insertOrderDetails . "<br>" . mysqli_error($conn);
				}
			}
			else
			{
				echo "<script language='javascript'>
				alert('Detail ID has already existed.');</script>";
			}
			
		} 
		else 
		{
		  echo "Error: " . $insertOrders . "<br>" . mysqli_error($conn);
		}
	}
	else //checkDetailID($conn, $orderID) == true ; order more than 1 product OR add order details on existing orderID
	{
		if(checkDetailID($conn, $detailID, $orderID) == false) //don't have same detailID
		{
			if(checkProdID($conn, $prodID, $orderID) == false) //don't have same prodID
			{
				$insertOrderDetails = "INSERT INTO orderdetails(detailID,quantity,orderID,prodID)values('$detailID',1,'$orderID','$prodID')";
						
				if (mysqli_query($conn, $insertOrderDetails)) 
				{
					echo "<script language='javascript'>
					alert('Product on current order has been add into the cart.');window.location='search.php';</script>";
				} 
				else 
				{
					echo "Error: " . $insertOrderDetails . "<br>" . mysqli_error($conn);
				}
			}
			else
			{
				echo "<script language='javascript'>
				alert('Product ID has already existed.');</script>";
			}
		}
		else
		{
			echo "<script language='javascript'>
			alert('Detail ID has already existed.');</script>";
		}
		
	}
}

if(isset($_POST['another']))
{
	echo"<script language='javascript'>window.location='search.php';</script>";
}

?>
