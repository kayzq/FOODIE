<?php
session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1) {
    header("Location:/FOODIE/landing-page/index.html");
    exit();
}


$detailID = $_GET['detailID']; 

$qry = mysqli_query($conn,"SELECT * FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID INNER JOIN prodtypes t ON p.typeID = t.typeID WHERE detailID='$detailID'"); // select query

$data = mysqli_fetch_array($qry); 

if(isset($_POST['Update'])) 
{
	$quantity = $_POST['quantity'];
	
    $update = "UPDATE orderdetails SET quantity=$quantity WHERE detailID='$detailID'";

	$run=mysqli_query($conn,$update);
	
	if($run)
	{
		echo"<script language='javascript'>
		alert('Quantity of product has been updated successfully.');window.location='cart.php';</script>";
	}
	else
	{
		echo "<script language='javascript'>alert('Error! Failed to update quantity of product.');window.location='cart.php';</script>";
	}
}
if(isset($_POST['Cancel']))
{
	echo"<script language='javascript'>window.location='cart.php';</script>";
}



?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="editQCart.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
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

        <form method="post">

            <section class="info-section"> 
              <h3 class="section-title">Edit quantity of the selected product</h3>
              <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Detail ID</span>
                    <span class="info-value"><?php echo $data['detailID']; ?></span> 
                </div>
                <div class="info-item">
                    <span class="info-label">Product ID</span>
                    <span class="info-value"><?php echo $data['prodID']; ?></span>
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
                    <span class="info-label">Price</span>
                    <span class="info-value"><input type="hidden" id="price" value="<?php echo $data['price'] ?>" name="price">RM <?php echo $data['price'] ?></input></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Product Description</span>
                    <span class="info-value"><?php echo $data['prodDesc']; ?></span>
                </div>
              </div>

              <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Quantity</span>
                    <span class="info-value"><input type="number" id="quantity" min="1" max="10" name="quantity" value="<?php echo $data['quantity'] ?>" placeholder="<?php echo $data['quantity'] ?>"  required></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total Price</span>
                    <span class="info-value">RM <input type="number" id="total" name="total" value="" readonly></input></span>
                </div>
              </div>
            </section>
            
            <div class="buttton-grid">
              <button type="submit" id="Update" name="Update" title="Button to update quantity of product" class="checkout-btn">Update Quantity
                <img src="/FOODIE/images/check.png" alt="">
              </button>
              <a href="cart.php">
                <button type="submit" id="Cancel" name="Cancel" onclick="return true"  title="Button to go back to the cart" class="cancel-btn">Cancel
                <img src="/FOODIE/images/x_icon.png" alt="">
                </button>
              </a>
            </div>
        </form>
      </main>
    </div>
  </body>
  <script>

	$('#quantity').change(function() 
	{
	   var quantity = $("#quantity").val();
	   var iPrice = $("#price").val();

	   var total = quantity * iPrice;

	   $("#total").val(total.toFixed(2)); // sets the total price input to the quantity * price
	});
	
	$('#quantity').keyup(function() 
	{
	   var quantity = $("#quantity").val();
	   var iPrice = $("#price").val();

	   var total = quantity * iPrice;

	   $("#total").val(total.toFixed(2)); // sets the total price input to the quantity * price
	});
	
</script>
</html>