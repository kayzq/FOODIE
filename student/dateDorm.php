<?php

session_start();
include("studconnection.php");

if(isset($_POST['checkout'])) // when click on Update button
{
	$orderID = $_SESSION['orderID'];

	function checkCartList($conn,$orderID)
	{
		$found = false;
		$sql = "SELECT orderID FROM orderdetails WHERE orderID='".$orderID."'";
		$qry=mysqli_query($conn,$sql);
		$row=mysqli_num_rows($qry);
		
		if($row > 0)
		{
			$found = true;
		}
		return $found;
	}


	if(checkCartList($conn, $orderID) == true) //cart have order details
	{
		//DORM
		$dormLevel = $_POST['dormLevel'];
		$dormNo = $_POST['dormNo'];
		$buildingID = $_POST['buildingID'];
		
		//DATE
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$todayDate = date("Y-m-d"); //2020-11-03
		$dDate = $_POST['deliveryDate'];
		$deliveryDate = date("Y-m-d", strtotime($dDate));
		

		if($deliveryDate <= $todayDate)
		{
			echo 
			"<script language='javascript'>
				alert('Delivery date must be after order date!');
				window.location='cart.php';
			</script>";
            exit();
		}
		else
		{
			$studGender = $_SESSION['studGender'];
					
			//BUILDING
			if($buildingID == "BD001") //Mat Kilau
			{
				//GENDER
				if($studGender == "F") //female stud who live in Mat Kilau will assign to female admin (ADM03) (Nurhayati)
				{
					$update = "UPDATE orders SET dormLevel='$dormLevel', dormNo='$dormNo', deliveryDate='$deliveryDate', orderDate='$todayDate', 
					buildingID='BD001', adminID='ADM03' WHERE orderID='$orderID'";
					if(mysqli_query($conn,$update))
					{
						$_SESSION['logoutPermission'] = 1; //yes
						$_SESSION['order4Receipt'] = $_SESSION['orderID']; //for display at receipt menu
						$_SESSION['orderID'] = ""; //stud can order again with new orderID
						echo "<script>alert('Order has been checkout. Sending receipt through email...');window.location='receipt.html';</script>";
					}
					else
					{
						echo "<script language='javascript'>alert('Error! Failed to checkout the order.');window.location='cart.php';</script>";
					}
				}
				else //($studGender == "M") male stud who live in mat kilau will assign to male admin (ADM04) (Iman)
				{
					$update = "UPDATE orders SET dormLevel='$dormLevel', dormNo='$dormNo', deliveryDate='$deliveryDate', orderDate='$todayDate', 
					buildingID='BD001', adminID='ADM04' WHERE orderID='$orderID'";
					if(mysqli_query($conn,$update))
					{
						$_SESSION['logoutPermission'] = 1;
						$_SESSION['order4Receipt'] = $_SESSION['orderID']; //for display at receipt menu
						$_SESSION['orderID'] = ""; //stud can order again with new orderID
						echo "<script language='javascript'>alert('Order has been checkout. Sending receipt through email...');window.location='receipt.html';</script>";
					}
					else
					{
						echo "<script language='javascript'>alert('Error! Failed to checkout the order.');window.location='cart.php';</script>";
					}
				}
			}
			
			if ($buildingID == "BD002") //Tun Teja 1 
			{
				//GENDER
				if($studGender == "M") //Tun Teja buildings are for female students 
				{
					echo "<script language='javascript'>alert('Tun Teja buildings are for female students!');window.location='cart.php';</script>";
				}
				else //female stud who live in Tun Teja 1 will assign to female admin (ADM01) (Ainatul)
				{
					$update = "UPDATE orders SET dormLevel='$dormLevel', dormNo='$dormNo', deliveryDate='$deliveryDate', orderDate='$todayDate', 
					buildingID='BD002', adminID='ADM01' WHERE orderID='$orderID'";
					if(mysqli_query($conn,$update))
					{
						$_SESSION['logoutPermission'] = 1;
						$_SESSION['order4Receipt'] = $_SESSION['orderID']; //for display at receipt menu
						$_SESSION['orderID'] = ""; //stud can order again with new orderID
						echo "<script language='javascript'>alert('Order has been checkout. Sending receipt through email...');window.location='receipt.html';</script>";
					}
					else
					{
						echo "<script language='javascript'>alert('Error! Failed to checkout the order.');window.location='cart.php';</script>";
					}
				}
			}
			
			if ($buildingID == "BD003") //Tun Teja 2
			{
				//GENDER
				if($studGender == "M") //Tun Teja buildings are for female students 
				{
					echo "<script language='javascript'>alert('Tun Teja buildings are for female students!');window.location='cart.php';</script>";
				}
				else //female stud who live in Tun Teja 1 will assign to female admin (ADM02) (Erni)
				{
					$update = "UPDATE orders SET dormLevel='$dormLevel', dormNo='$dormNo', deliveryDate='$deliveryDate', orderDate='$todayDate', 
					buildingID='BD003', adminID='ADM02' WHERE orderID='$orderID'";
					if(mysqli_query($conn,$update))
					{
						$_SESSION['logoutPermission'] = 1;
						$_SESSION['order4Receipt'] = $_SESSION['orderID']; //for display at receipt menu
						$_SESSION['orderID'] = ""; //stud can order again with new orderID
						echo"<script language='javascript'>alert('Order has been checkout. Sending receipt through email...');window.location='receipt.html';</script>";
					}
					else
					{
						echo "<script language='javascript'>alert('Error! Failed to checkout the order.');window.location='cart.php';</script>";
					}
				}
			}
		}
	}
	else //cart do not have order details
	{
		echo "<script language='javascript'>alert('Cart is empty! Please search product or cancel the order.');window.location='cart.php';</script>";
	}
	
}


if(isset($_POST['cancel'])) //cancel order
{
	$orderID = $_SESSION['orderID'];
	
	$delOR = mysqli_query($conn, "DELETE FROM orderdetails WHERE orderID='$orderID'");

	if($delOR)
	{
		$del = mysqli_query($conn, "DELETE FROM orders WHERE orderID='$orderID'");

		if($del)
		{
			$_SESSION['orderID'] = "";
			$_SESSION['logoutPermission'] = 1; //yes
			echo
			"<script language='javascript'>
			alert('Order and order details has been deleted successfully.');window.location='home.php';</script>";
		}
		else
		{
			echo
			"<script language='javascript'>
			alert('Error! Failed to delete order and order details.');window.location='cart.php';</script>";
		}
	}
	else
	{
		echo 
		"<script language='javascript'>
		alert('Error! Failed to delete order details');window.location='cart.php';</script>";
	}
}

?>