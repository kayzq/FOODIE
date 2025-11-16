<?php
  session_start();
  include("studconnection.php");

  if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
  {
    header("Location:/FOODIE/landing-page/index.html");
    exit();
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="receiptsStyle.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>FOODIE - Receipts</title>
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="home.php" class="nav-item">HOME</a>
          <a href="search.php" class="nav-item">SEARCH</a>
          <a href="" class="nav-item active">RECEIPTS</a>
          <a href="cart.php" class="nav-item">CART, DORM & DATES</a>
          <a href="adminContact.php" class="nav-item">ADMIN CONTACT</a>
          <a href="setting.php" class="nav-item">SETTINGS</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="header-title">RECEIPTS</header>

        <section class="info-section">
          <h3 class="section-title">RECEIPTS THROUGH EMAIL</h3>
          <div class="info-grid">
            <span class="order-id">YOUR ORDER ID: <?php 
                if ($_SESSION['order4Receipt'] != "")
                  echo $_SESSION['order4Receipt'];
                else
                  echo "<h3>Checkout first to have your receipts sent to your email</h3>";
              ?>
            </span>
           
        
        <?php
          if($_SESSION['order4Receipt'] != "") //have checkout the order
          {?>
            <center>
            <h2 style="font-family: 'Poppins'">Receipt Has Be Sent To Your Email.<br>Thank You For Ordering With Us, See You Again!</h2>
            
            <span style="font-size:20px; font-family: 'Poppins', sans-serif;">Did not get the email?
            <a href="emailReceipt.php" class="clickhere">Click here</a> to resend the email.</span><br><br><br>
            </center>
          <?php
          }
        ?>
            
          </div>
        </section>
      </main>
    </div>
  </body>
</html>
