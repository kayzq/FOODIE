<?php
session_start();
include("adminconnection.php");

// check if user logged in
if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1) {
    header("Location: /FOODIE/landing-page/index.html");
    exit();
}

if(isset($_POST["add"])) {
    // collect form data
    $adminName    = $_POST["adminName"];
    $adminGender  = $_POST["adminGender"];
    $adminEmail   = $_POST["adminEmail"];
    $adminPhoneNo = $_POST["adminPhoneNo"];
    $username     = $_POST["username"];
    $adminIcNo    = $_POST["adminIcNo"];

    // Get the last adminID
    $result = mysqli_query($conn, "SELECT adminID FROM admins ORDER BY adminID DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    $lastID = $row['adminID']; // e.g. 'ADM04'

    // Generate next adminID
    $number = (int)substr($lastID, 3);   // get numeric part
    $number++;                             // increment
    $newAdminID = "ADM" . str_pad($number, 2, "0", STR_PAD_LEFT); // e.g. ADM05

    // insert query with new adminID
    $insert = "INSERT INTO admins (adminID, adminName, adminGender, adminEmail, adminPhoneNo, username, adminIcNo)
               VALUES ('$newAdminID', '$adminName', '$adminGender', '$adminEmail', '$adminPhoneNo', '$username', '$adminIcNo')";

    $run = mysqli_query($conn, $insert);

    if($run) {
        echo "<script>alert('New admin added successfully!'); window.location='/FOODIE/staff/adminSuper.php';</script>";
    } else {
        echo "<script>alert('Error: Failed to add new admin.');</script>";
    }
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width" />
  <link rel="stylesheet" href="adminSuper.css" />
</head>

<body>
  <div class="container">
    <aside class="sidebar">
      <div class="logo-container">
        <div class="logo">FOODIE.</div>
      </div>
      <nav class="nav-menu">
        <a href="adminDashboard.php" class="nav-item">DASHBOARD</a>
        <a href="adminSuper.php" class="nav-item active">SUPER ADMINS</a>
        <a href="adminProducts.php" class="nav-item">PRODUCTS</a>
        <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
        <a href="adminOrders.php" class="nav-item">ORDERS</a>
        <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <header class="header-title">ADD AN ADMIN</header>
      <section class="info-section">
        <form method="POST">
          <div class="form-group">
            <label for="adminName">Admin Name</label>
            <input type="text" id="adminName" name="adminName" maxlength="45" required style="font-size:17px;"/>
          </div>

          <div class="form-group">
            <label for="adminGender">Gender</label>
            <input type="text" id="adminGender" name="adminGender" maxlength="10" required style="font-size:17px;"/>
          </div>

          <div class="form-group">
            <label for="adminPhoneNo">Phone No</label>
            <input type="text" id="adminPhoneNo" name="adminPhoneNo" maxlength="45" required style="font-size:17px;"/>
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="45" required style="font-size:17px;"/>
          </div>

          <div class="form-group">
            <label for="adminIcNo">Admin IC</label>
            <input type="text" id="adminIcNo" name="adminIcNo" maxlength="45" required style="font-size:17px;"/>
          </div>

          <div class="form-group">
            <label for="adminEmail">Admin Email</label>
            <input type="text" id="adminEmail" name="adminEmail" maxlength="45" required style="font-size:17px;"/>
          </div>

          <button type="submit" id="add" name="add" title="Button to add new admin" class="btn">
            Add Admin
            <img src="/FOODIE/images/check.png" alt="Select" width="18" height="18" />
          </button>

          <a class="btn-x" href="/FOODIE/staff/adminSuperChoose.html">
            Cancel
            <img src="/FOODIE/images/x_icon.png" alt="Select" width="14" height="14" />
          </a>
        </form>
      </section>
    </main>
  </div>
</body>
</html>
