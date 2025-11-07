<?php

include("adminconnection.php");

function checkProdID($conn,$prodID)
{
	$found = false;
	$sql = "SELECT prodID FROM products WHERE prodID='".$prodID."'";
	$qry=mysqli_query($conn,$sql);
	$row=mysqli_num_rows($qry);
	
	if($row > 0)
	{
		$found = true;
	}
	return $found;
}

$prodID = $_POST['prodID'];
$prodName = $_POST['prodName'];
$price = $_POST['price'];
$prodDesc = $_POST['prodDesc'];
$type = $_POST['productTypeID'];


if (isset($_POST['Add']))
{
	if(checkProdID($conn, $prodID) == false)
	{
		$query = "INSERT INTO products(prodID,prodName,price,prodDesc,typeID)values('$prodID','$prodName','$price','$prodDesc','$type')";
		mysqli_query($conn,$query);
		echo
		"<script language='javascript'>
		alert('Product has been added successfully.');
		window.location='adminProducts.php';</script>";
	}
	else
	{
		echo 
		"<script language='javascript'>
		alert('Product ID has already existed.');
		window.location='adminAddProduct.php'</script>";
	}
}

?>