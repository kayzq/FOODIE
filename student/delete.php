<?php

include("studconnection.php");
	
$id = $_GET['detailID'];
	
$del = mysqli_query($conn, "DELETE FROM orderdetails WHERE detailID='$id'");

if($del)
{
	echo "<script language='javascript'>
		alert('Product has been deleted successfully from the cart.');
		window.location='cart.php';
		</script>";	
}
else
{
	echo"<script language='javascript'>
		alert('Error! Failed to delete product from the cart.');
		window.location='cart.php';
		</script>";
}

?>