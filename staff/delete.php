<?php

include("adminconnection.php");

$id = $_GET['prodID'];
	
$del = mysqli_query($conn, "UPDATE products set is_active = '0' WHERE prodID='$id'");

if($del)
{
	
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


?>