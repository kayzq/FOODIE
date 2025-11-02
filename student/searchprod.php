<?php
session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location:/FOODIE/landing-page/index.html");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="searchprod.css" />
  </head>

  <!--<script>alert('Notice! Once selecting product, student must NOT log out until done checkout or cancel the order.')</script>-->
  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">  
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="home.php" class="nav-item">HOME</a>
          <a href="#" class="nav-item">SEARCH</a>
          <a href="#" class="nav-item">RECEIPTS</a>
          <a href="#" class="nav-item">CART, DORM &amp; DATES</a>
          <a href="adminContact.php" class="nav-item active">ADMIN CONTACT</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="header-title">Search</header>
  
        <!-- personal information section-->
        <section class="info-section"> 
          <h3 class="section-title">YOUR ORDER ID: <?php echo $_SESSION['orderID']; ?></h3>

          <form action="result.php" method="GET">

            <!-- Choose Type -->
            <div class="choose">
              <label for="typeID">CHOOSE TYPE:</label>
              <select name="typeID" id="typeID" class="chooseselect">
                 <option value="ALL" selected>All Products</option>
                <?php 
                  $sqlprodtypes = "SELECT * FROM prodtypes ORDER BY typeID ASC";
                  $qryprodtypes = mysqli_query($conn, $sqlprodtypes);
                  $rowprodtypes = mysqli_num_rows($qryprodtypes);

                  if($rowprodtypes > 0)
                  {
                    while($dprodtypes = mysqli_fetch_assoc($qryprodtypes))
                    {
                      if(isset($typeID) && $typeID == $dprodtypes['typeID'])
                        echo "<option value='".$dprodtypes['typeID']."' selected>".$dprodtypes['typeName']." (".$dprodtypes['typeDesc'].")</option>";
                      else
                        echo "<option value='".$dprodtypes['typeID']."'>".$dprodtypes['typeName']." (".$dprodtypes['typeDesc'].")</option>";
                    }
                  }
                ?>
              </select>
            </div>

            <!-- Sort By -->
            <div class="sort">
              <label for="sortBy">SORT BY:</label>
              <select id="sortBy" name="sortBy" class="sortselect">
                <option value="Price">Price</option>
                <option value="Product Name">Product Name</option>
              </select>
            </div>

            <!-- Submit Button -->

            <div class = "search-box">
              <input type="text" class="btn"  placeholder="SEARCH" name="keyword" id="keyword">
              <button type="submit">
                <img src="/FOODIE/images/search-icon.png" alt="Search"> 
              </button>
             </div>

          </form>
        </section>
      </main>
    </div>
  </body>
</html>
