<?php
  session_start();
  include("studconnection.php");

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
    <link rel="stylesheet" href="adminContactStyle.css" />
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
          <a href="home.php" class="nav-item">HOME</a>
          <a href="search.php" class="nav-item">SEARCH</a>
          <a href="receipts.html" class="nav-item">RECEIPTS</a>
          <a href="cart.html" class="nav-item">CART, DORM & DATES</a>
          <a href="#" class="nav-item active">ADMIN CONTACT</a>
          <a href="setting.html" class="nav-item">SETTINGS</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
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

              echo '
                <!-- Personal Information Section -->
                <section class="info-section">
                  <h3 class="section-title">'.$adminName.'</h3>
                  <div class="info-grid">
                    <div class="info-item">
                      <span class="info-label">Email Address</span>
                      <span class="info-value">'.$adminEmail.'</span>
                    </div>
                    <div class="info-item">
                      <span class="info-label">Phone No</span>
                      <span class="info-value">'.$adminPhoneNo.'</span>
                    </div>
                  </div>
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