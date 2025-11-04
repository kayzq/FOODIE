<?php
session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
    exit();
}

$sql = "SELECT * FROM admins";
$qry = mysqli_query($conn, $sql);

echo '
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
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
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
';

while($r = mysqli_fetch_assoc($qry)) {
    $adminID = $r['adminID'];

    // Extract short name (before "BIN"/"BINTI" or first word)
    $sqlname = "SELECT 
        TRIM(
            CASE
                WHEN adminName LIKE '% BIN %' THEN SUBSTRING_INDEX(adminName, ' BIN ', 1)
                WHEN adminName LIKE '% BINTI %' THEN SUBSTRING_INDEX(adminName, ' BINTI ', 1)
                ELSE SUBSTRING_INDEX(adminName, ' ', 1)
            END
        ) AS shortName
    FROM admins 
    WHERE adminID = '$adminID'";
    
    $qryName = mysqli_query($conn, $sqlname);
    $result = mysqli_fetch_assoc($qryName);

    if(isset($result['shortName'])) {
        $shortName = $result['shortName'];
    } else {
        $shortName = $r['adminName'];
    }

    $displayName = ucwords(strtolower($shortName));

    echo '
        <!-- Personal Information Section -->
        <section class="info-section">
          <h3 class="section-title">'.$displayName.'</h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">Email Address</span>
              <span class="info-value">'.$r['adminEmail'].'</span>
            </div>
            <div class="info-item">
              <span class="info-label">Phone No</span>
              <span class="info-value">'.$r['adminPhoneNo'].'</span>
            </div>
          </div>
        </section>
    ';
}

echo '
      </main>
    </div>
  </body>
</html>
';
?>
