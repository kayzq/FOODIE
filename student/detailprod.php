<?php
session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1) {
    header("Location:/FOODIE/landing-page/index.html");
    exit();
}

$prodID1 = $_GET['prodID']; 
$qry = mysqli_query($conn,"SELECT * FROM products p INNER JOIN prodtypes pt ON p.typeID = pt.typeID WHERE prodID='$prodID1'");
$data = mysqli_fetch_array($qry);

// Generate unique detailID for the form
$i = 1;
while($i == 1) {
    $uniqId = substr(str_shuffle("0123456789"), 0, 3);
    $detailID = "DT".$uniqId;
    $sql = "SELECT detailID FROM orderdetails WHERE detailID='".$detailID."'";
    $qry=mysqli_query($conn,$sql);
    $row=mysqli_num_rows($qry);
    if($row == 0) {
        $i = -1;
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="detailprod.css " />
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">  
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="home.php" class="nav-item">HOME</a>
          <a href="" class="nav-item active">SEARCH</a>
          <a href="receipts.html" class="nav-item">RECEIPTS</a>
          <a href="cart.php" class="nav-item">CART, DORM & DATES</a>
          <a href="adminContact.php" class="nav-item">ADMIN CONTACT</a>
          <a href="setting.php" class="nav-item">SETTINGS</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="header-title">Search</header>
        
        <!-- Display success/error messages -->
        <?php if(isset($_SESSION['success_message'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 5px;">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error_message'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 5px;">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="add_to_cart_handler.php">
            <input type="hidden" name="detailID" value="<?php echo $detailID; ?>">
            <input type="hidden" name="studID" value="<?php echo $_SESSION['studID']; ?>">
            <input type="hidden" name="prodID" value="<?php echo $data['prodID']; ?>">
            <input type="hidden" name="prodName" value="<?php echo $data['prodName']; ?>">

            <section class="info-section"> 
              <h3 class="section-title">YOUR ORDER ID: <?php echo $_SESSION['orderID']; ?></h3>
              <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Product ID</span>
                    <span class="info-value"><?php echo $data['prodID']; ?></span> 
                </div>
                <div class="info-item">
                    <span class="info-label">Price</span>
                    <span class="info-value"><?php echo $data['price']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Type Name</span>
                    <span class="info-value"><?php echo $data['typeName']; ?></span>
                </div>
              </div>
              
              <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Product Name</span>
                    <span class="info-value"><?php echo $data['prodName']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Description</span>
                    <span class="info-value"><?php echo $data['prodDesc']; ?></span>
                </div>
              </div>
            </section>
            
            <div class="buttton-grid">
              <button type="submit" name="select" class="cart">Add To Cart 
                <img src="/FOODIE/images/cart.png" alt="">
              </button>
              <button type="submit" name="another" class="other">Select Another Product
                <img src="/FOODIE/images/go_back.png" alt="">
              </button>
            </div>
        </form>
      </main>
    </div>
  </body>
</html>