<?php
  session_start();
  include("adminconnection.php");

  if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
  {
      header("Location: /FOODIE/landing-page/index.html");
      exit();
  }
?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="adminSuper.css" />
    <title>Admin Contact</title>
  </head>

  <body>
    <div class="container">

      <aside class="sidebar">

        <!-- FOODIE LOGO -->
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
    
        <!-- SIDEBAR MENU -->
        <nav class="nav-menu">
          <a href="adminDashboard.php" class="nav-item">DASHBOARD</a>
          <a href="adminSuper.php" class="nav-item">SUPER ADMINS</a>
          <a href="adminProducts.php" class="nav-item">PRODUCTS</a>
          <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
          <a href="adminOrders.php" class="nav-item active">ORDERS</a>
          <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
        </nav>

      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="header-title">ADMIN CONTACT</header>

        <?php
          $sql = "SELECT * FROM admins";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) > 0)
          {
            while($row = mysqli_fetch_assoc($result))
            {
              $adminName = $row['adminName'];
              $adminPhoneNo = $row['adminPhoneNo'];
              $adminEmail = $row['adminEmail'];
              $username = $row['username'];
              $adminID = $row['adminID'];
              $adminGender = $row['adminGender'];
              $adminIcNo = $row['adminIcNo'];


              echo '
                <!-- Personal Information Section -->
                <section class="info-section">
                  <h3 class="section-title">'.$adminName.'</h3>
                  <div class="info-grid">
                    <div class="info-item">
                      <span class="info-label">Admin Id</span>
                      <span class="info-value">'.$adminID.'</span>
                    </div>
                    <div class="info-item">
                      <span class="info-label">Admin Name</span>
                      <span class="info-value">'.$adminName.'</span>
                    </div>
                    <div class="info-item">
                      <span class="info-label">Admin Gender</span>
                      <span class="info-value">'.$adminGender.'</span>
                    </div>
                    <div class="info-item">
                      <span class="info-label">Phone No</span>
                      <span class="info-value">'.$adminPhoneNo.'</span>
                    </div>
                    <div class="info-item">
                      <span class="info-label">Username</span>
                      <span class="info-value">'.$username.'</span>
                    </div>
                    <div class="info-item">
                      <span class="info-label">IC NO</span>
                      <span class="info-value">'.$adminIcNo.'</span>
                    </div>
                    <div class="info-item">
                      <span class="info-label">Admin Email</span>
                      <span class="info-value">'.$adminEmail.'</span>
                    </div>
                  </div>

                  <a href="/FOODIE/staff/adminSuperEditAdmin2.php?adminID='.$adminID.'">
                    <img src="/FOODIE/images/edit_icon.png" alt="Edit" class="icon-btn" />
                  </a>
                </section> ';
            }
          }
          
          else
          {
            echo '<p>No admin contact information available.</p>';
          }
        ?>
      </main>

    </div>
  </body>
</html>