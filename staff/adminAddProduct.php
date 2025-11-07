<?php
session_start();
include("adminconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
}

// Handle form submission
if(isset($_GET['submit_type'])) {
    $selectedTypeID = $_GET['typeID'];
    header("Location: /FOODIE/staff/adminAddProductFill.php?typeID=" . $selectedTypeID);
    exit();
}

   
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="adminAddProduct.css" />
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="/FOODIE/staff/adminDashboard.php" class="nav-item active"
            >DASHBOARD</a
          >
          <a href="/FOODIE/staff/adminSuper.html" class="nav-item"
            >SUPER ADMINS</a
          >
          <a href="/FOODIE/staff/adminProducts.php" class="nav-item"
            >PRODUCTS</a
          >
          <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
          <a href="/FOODIE/staff/adminOrders.html" class="nav-item">ORDERS</a>
          <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">ADD PRODUCT</header>

        <!-- Personal information section -->
        <section class="info-section">
          <h3 class="section-title">FILL IN THE DETAILS OF THE PRODUCT</h3>
          <form method="GEt" action="">
            <div class="box1">
              <div class="types-description">
                <span>Types &<br />Description </span>
              </div>
              <select name="typeID" id="typeID" class="types-description-class">
                <?php 
                  $sqlprodtypes = "SELECT * FROM prodtypes ORDER BY typeID ASC";
                  $qryprodtypes = mysqli_query($conn, $sqlprodtypes);
                  $rowprodtypes = mysqli_num_rows($qryprodtypes);

                  if($rowprodtypes > 0) {
                    while($dprodtypes = mysqli_fetch_assoc($qryprodtypes)) {
                      echo "<option value='".$dprodtypes['typeID']."'>".$dprodtypes['typeName']." (".$dprodtypes['typeDesc'].")"."</option>";
                    }
                  }
                ?>
              </select>
            </div>

            <button type="submit" name="submit_type" class="btn">
              Choose Type
              <img src="/FOODIE/images/check.png" alt="Select" width="14" height="14" />
            </button>
          </form>
        </section>
      </main>
    </div>
  </body>
</html>