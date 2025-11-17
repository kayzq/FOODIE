<?php
session_start();
include("studconnection.php");

// Function to check if cart has items
function checkCartList($conn, $orderID) {
    $sql = "SELECT orderID FROM orderdetails WHERE orderID='$orderID'";
    $qry = mysqli_query($conn, $sql);
    return mysqli_num_rows($qry) > 0;
}

// Function to get a random active admin based on building & student gender
function getRandomAdmin($conn, $buildingID, $studGender) {
    $assignedGender = "";

    // RULES BASED ON BUILDING
    if ($buildingID == "BD001") { // Mat Kilau
        $assignedGender = "M"; // male admins only
    } elseif ($buildingID == "BD002" || $buildingID == "BD003") { // Tun Teja 1 & 2
        if ($studGender == "M") return "INVALID"; // male students not allowed
        $assignedGender = "F"; // female admins only
    }

    $sql = "SELECT adminID FROM admins 
            WHERE adminGender='$assignedGender' AND is_active=1";
    $result = mysqli_query($conn, $sql);

    $admins = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $admins[] = $row['adminID'];
    }

    if (count($admins) > 0) return $admins[array_rand($admins)];

    return null; // no admin available
}

// CHECKOUT PROCESS
if (isset($_POST['checkout'])) {

    $orderID = $_SESSION['orderID'];

    if (!checkCartList($conn, $orderID)) {
        echo "<script>alert('Cart is empty! Please add items first.');window.location='cart.php';</script>";
        exit();
    }

    // Gather input
    $dormLevel = $_POST['dormLevel'];
    $dormNo = $_POST['dormNo'];
    $buildingID = $_POST['buildingID'];
    $deliveryDate = date("Y-m-d", strtotime($_POST['deliveryDate']));
    $todayDate = date("Y-m-d");
    $studGender = $_SESSION['studGender'];

    if ($deliveryDate <= $todayDate) {
        echo "<script>alert('Delivery date must be after today!');window.location='cart.php';</script>";
        exit();
    }

    // Get random admin
    $assignedAdmin = getRandomAdmin($conn, $buildingID, $studGender);

    if ($assignedAdmin == "INVALID") {
        echo "<script>alert('This building is for female students only!');window.location='cart.php';</script>";
        exit();
    }

    if ($assignedAdmin == null) {
        echo "<script>alert('No active admin available for this building.');window.location='cart.php';</script>";
        exit();
    }

    // Update the order
    $updateSQL = "UPDATE orders SET 
        dormLevel='$dormLevel', dormNo='$dormNo', deliveryDate='$deliveryDate',
        orderDate='$todayDate', buildingID='$buildingID', adminID='$assignedAdmin'
        WHERE orderID='$orderID'";

    if (mysqli_query($conn, $updateSQL)) {
        $_SESSION['logoutPermission'] = 1;
        $_SESSION['order4Receipt'] = $_SESSION['orderID'];
        $_SESSION['orderID'] = ""; // allow new order
        echo "<script>alert('Order has been checked out. Sending receipt...');window.location='emailReceipt.php';</script>";
    } else {
        echo "<script>alert('Error updating order!');window.location='cart.php';</script>";
    }
}

// CANCEL ORDER
if (isset($_POST['cancel'])) {
    $orderID = $_SESSION['orderID'];
    mysqli_query($conn, "DELETE FROM orderdetails WHERE orderID='$orderID'");
    mysqli_query($conn, "DELETE FROM orders WHERE orderID='$orderID'");
    $_SESSION['orderID'] = "";
    $_SESSION['logoutPermission'] = 1;
    echo "<script>alert('Order cancelled successfully.');window.location='home.php';</script>";
}
?>
