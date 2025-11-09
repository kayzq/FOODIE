<?php
session_start();
include("adminconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
}

      $adminId = $_GET["adminID"];

      $data = mysqli_query($conn,"SELECT * FROM admins WHERE adminID='$adminId'"); // select query

      $row = mysqli_fetch_assoc($data);
  
      if(isset($_POST["edit"])){
        $adminName = $_POST["adminName"];
        $adminGender = $_POST["adminGender"];
        $adminEmail = $_POST["adminEmail"];
        $adminPhone = $_POST["adminPhoneNo"];
        $username = $_POST["username"];

        $update = "UPDATE admins SET adminName='$adminName', adminGender='$adminGender', adminEmail='$adminEmail', adminPhoneNo='$adminPhone', username='$username' WHERE adminID='$adminId'";
      
        $run=mysqli_query($conn,$update);

        if($run)
        {
          echo"<script language='javascript'>
          alert('Details of admin has been updated successfully.');window.location='/FOODIE/staff/adminSuperEditAdmin.php';</script>";
        }
        else
        {
          echo "<script language='javascript'>alert('Error! Failed to update details of admin.');window.location='/FOODIE/staff/adminSuperChoose.html';</script>";
        }
      }
      if(isset($_POST['Cancel']))
      {
        echo"<script language='javascript'>history.back();</script>";
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
          <a href="adminSuper.php" class="nav-item">SUPER ADMINS</a>
          <a href="adminProducts.php" class="nav-item">PRODUCTS</a>
          <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
          <a href="adminOrders.php" class="nav-item active">ORDERS</a>
          <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">EDIT AN ADMIN</header>
        <section class="info-section">
          <form method="POST">
            <div class="form-group">
              <label for="detailID">Admin ID: </label>
              <span><?php echo $row['adminID'] ?></span>
              <input type="hidden" id="adminID" name="adminID" value="<?php echo $row['adminID'] ?>"/>
            </div>

            <div class="form-group">
              <label for="productName">Admin Name</label>
              <input type="text" id="adminName" name="adminName" value="<?php echo $row['adminName'] ?>" placeholder="<?php echo $row  ['adminName'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="productName">Gender</label>
              <input type="text" id="adminGender" name="adminGender" value="<?php echo $row['adminGender'] ?>" placeholder="<?php echo $row  ['adminGender'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="productName">Phone No</label>
              <input type="text" id="adminPhoneNo" name="adminPhoneNo" value="<?php echo $row['adminPhoneNo'] ?>" placeholder="<?php echo $row['adminPhoneNo'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>
            
            <div class="form-group">
              <label for="productName">Username</label>
              <input type="text" id="username" name="username" value="<?php echo $row['username'] ?>" placeholder="<?php echo $row  ['username'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="detailID">Admin IC: </label>
              <span><?php echo $row['adminIcNo'] ?></span>
              <input type="hidden" id="adminIcNo" name="adminIcNo" value="<?php echo $row['adminIcNo'] ?>"/>
            </div>

            <div class="form-group">
              <label for="productName">Admin Email</label>
              <input type="text" id="adminEmail" name="adminEmail" value="<?php echo $row['adminEmail'] ?>" placeholder="<?php echo $row  ['adminEmail'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <button type="submit" id="edit" name="edit" title="Button to update details of admin" class="btn">Edit Admin<img
              src="/FOODIE/images/check.png"
              alt="Select"
              width="18"
              height="18"
              />
            </button>

            <a class="btn-x" href="/FOODIE/staff/adminSuperChoose.html"
              >Cancel<img
              src="/FOODIE/images/x_icon.png"
              alt="Select"
              width="14"
              height="14"
              />
            </a>
          </form>

        </section>
      </main>
    </div>
  </body>
</html>