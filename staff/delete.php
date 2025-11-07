<?php

include("adminconnection.php");

$id = $_GET['prodID'];
	
$delOD = mysqli_query($conn, "DELETE FROM orderdetails WHERE prodID='$id'");

if($delOD)
{
	$del = mysqli_query($conn, "DELETE FROM products WHERE prodID='$id'");

	
	if($del)
	{
		mysqli_close($conn);
		echo
		"<script language='javascript'>
		alert('Product has been deleted successfully.');
		window.location='adminProducts.php';
		</script>";	
	}
	else
	{
		echo
		"<script language='javascript'>
		alert('Error! Failed to delete product.');
		window.location='adminProducts.php';
		</script>";
	}
}
else
{
	echo 
	"<script language='javascript'>
	alert('Error! Failed to delete product');
	window.location='adminProducts.php';
	</script>";
}
?>