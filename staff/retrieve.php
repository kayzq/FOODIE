<?php
include("adminconnection.php");

$id = $_GET['prodID'];

// Reactivate product (undo deletion)
$retrieve = mysqli_query($conn, "UPDATE products SET is_active = '1' WHERE prodID='$id'");

if($retrieve)
{
    echo "
    <script language='javascript'>
    alert('Product has been successfully retrieved.');
    window.location='adminProducts.php';
    </script>";
}
else
{
    echo "
    <script language='javascript'>
    alert('Error! Failed to retrieve product.');
    window.location='adminProducts.php';
    </script>";
}
?>
