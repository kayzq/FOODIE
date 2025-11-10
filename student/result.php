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
    <link rel="stylesheet" href="result.css" />
    <title>FOODIE - Search</title>
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">  
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="home.php" class="nav-item">HOME</a>
          <a href="#" class="nav-item active">SEARCH</a>
          <a href="receipts.php" class="nav-item">RECEIPTS</a>
          <a href="cart.php" class="nav-item">CART, DORM & DATES</a>
          <a href="adminContact.php" class="nav-item">ADMIN CONTACT</a>
          <a href="setting.php" class="nav-item">SETTINGS</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="header-title">Search</header>
  
        <!-- personal information section-->
        <section class="info-section"> 
          <h3 class="section-title">YOUR ORDER ID: <?php echo $_SESSION['orderID']; ?></h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">CHOOSE TYPE</span>
              <span class="info-value">
                <?php 
                  $typeID = $_GET['typeID'];
                  
                  if ($typeID == "PT001")
                    echo "Instants";
                  else if ($typeID == "PT002")
                    echo "Sweets";
                  else if ($typeID == "PT003")
                    echo "Biscuits";
                  else
                    echo "All Products";
                ?>
              </span>
            </div>
            <div class="info-item">
              <span class="info-label">SORT BY</span>
              <span class="info-value"><?php echo $_GET["sortBy"]; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">KEYWORD</span>
              <span class="info-value">
                <?php
                  $keywords = $_GET['keyword'];
                  if ($keywords == "")
                    echo "All";
                  else
                    echo htmlspecialchars($keywords); 
                ?>  
              </span>
            </div>
          </div>
          <a class="back" href="searchprod.php">Back</a>
        </section>

        <div class="product-grid">
          <table border="0">
            <tr>
              <th>Product Name</th>
              <th>Type Name</th>
              <th>Price</th>
              <th>Select</th> 
            </tr>

            <?php
                        // Sanitize input
              $prodtypes = mysqli_real_escape_string($conn, $_GET["typeID"]);
              $keywords = mysqli_real_escape_string($conn, $_GET["keyword"]);
              $sortByPrice = $_GET["sortBy"];

              // Choose sorting column
              $orderBy = ($sortByPrice == 'Price') ? 'p.price' : 'p.prodName';

              // Build base SQL — only active products
              $sql = "SELECT DISTINCT p.prodID, p.prodName, t.typeName, p.price 
                      FROM products p 
                      INNER JOIN prodtypes t ON p.typeID = t.typeID
                      WHERE p.is_active = '1'";

              // ✅ If not 'ALL', filter by selected type
              if (!empty($prodtypes) && $prodtypes != "ALL") {
                  $sql .= " AND p.typeID = '$prodtypes'";
              }

              // ✅ If keyword entered, show products that START with the word
              if (!empty($keywords)) {
                  $sql .= " AND LOWER(p.prodName) LIKE LOWER('$keywords%')";
              }

              // ✅ Add sorting
              $sql .= " ORDER BY $orderBy";


            // Execute query
            $qry = mysqli_query($conn, $sql);
            $row = mysqli_num_rows($qry);

            if ($row > 0) {
                while ($r = mysqli_fetch_array($qry)) 
                  {?>
                   
                    <tr>
                        <td><?php echo $r['prodName']?></td>
                        <td><?php echo $r['typeName']?></td>
                        <td><?php echo $r['price']?></td>
                        <td><a href="detailprod.php?prodID=<?php echo $r['prodID']; ?>" class='btn'><img src='/FOODIE/images/check.png' alt='Select' /></a></td>
                    </tr>
                  <?php
                }
            } else {
                echo "<tr><td colspan='4'>No results found.</td></tr>;";
            }
            ?>
          </table>
        </div>
      </main>
    </div>
  </body>
</html>
