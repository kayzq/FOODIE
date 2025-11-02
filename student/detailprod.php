<?php

session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location:/FOODIE/landing-page/index.html");
}


$prodID1 = $_GET['prodID']; // get id through query string

$qry = mysqli_query($conn,"SELECT * FROM products p INNER JOIN prodtypes pt ON p.typeID = pt.typeID WHERE prodID='$prodID1'"); // select query

$data = mysqli_fetch_array($qry); // fetch data



if (isset($_POST['select']))
{
	$orderID = $_SESSION['orderID'];
	
	$detailID = $_POST['detailID'];
	$prodID = $_POST['prodID'];
	$studID = $_POST['studID'];
	$prodName = $_POST['prodName'];

	function checkOrderID($conn,$orderID)
	{
		$found = false;
		$sql = "SELECT orderID FROM orders WHERE orderID='".$orderID."'";
		$qry=mysqli_query($conn,$sql);
		$row=mysqli_num_rows($qry);
		
		if($row > 0)
		{
			$found = true;
		}
		return $found;
	}
	
	function checkDetailID($conn,$detailID,$orderID)
	{
		$found = false;
		$sql = "SELECT detailID FROM orderdetails WHERE detailID='".$detailID."' AND orderID = '".$orderID."'";
		$qry=mysqli_query($conn,$sql);
		$row=mysqli_num_rows($qry);
		
		if($row > 0)
		{
			$found = true;
		}
		return $found;
	}
	
	function checkProdID($conn,$prodID,$orderID)
	{
		$found = false;
		$sql = "SELECT prodID FROM orderdetails WHERE prodID='".$prodID."' AND orderID = '".$orderID."'";
		$qry=mysqli_query($conn,$sql);
		$row=mysqli_num_rows($qry);
		
		if($row > 0)
		{
			$found = true;
		}
		return $found;
	}


	if(checkOrderID($conn, $orderID) == false) //new order
	{
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$todayDate = date("Y-m-d"); //2020-11-03
		
		$insertOrders = "INSERT INTO orders(orderID,orderDate,deliveryDate,dormLevel,dormNo,buildingID,studID,adminID)
						values('$orderID','$todayDate','$todayDate','1','1','BD001', $studID,'ADM01')";
		
		if (mysqli_query($conn, $insertOrders)) 
		{
			if(checkDetailID($conn, $detailID, $orderID) == false) //don't have same detailID
			{
				$insertOrderDetails = "INSERT INTO orderdetails(detailID,quantity,orderID,prodID)values('$detailID',1,'$orderID','$prodID')";
					
				if (mysqli_query($conn, $insertOrderDetails)) 
				{
					$_SESSION['logoutPermission'] = 0; //no log out
					
					echo "<script language='javascript'>
					alert('Product on new order has been add into the cart.');window.location='/FOODIE/student/search.php';</script>";
				} 
				else 
				{
					echo "Error: " . $insertOrderDetails . "<br>" . mysqli_error($conn);
				}
			}
			else
			{
				echo "<script language='javascript'>
				alert('Detail ID has already existed.');</script>";
			}
			
		} 
		else 
		{
		  echo "Error: " . $insertOrders . "<br>" . mysqli_error($conn);
		}
	}
	else //checkDetailID($conn, $orderID) == true ; order more than 1 product OR add order details on existing orderID
	{
		if(checkDetailID($conn, $detailID, $orderID) == false) //don't have same detailID
		{
			if(checkProdID($conn, $prodID, $orderID) == false) //don't have same prodID
			{
				$insertOrderDetails = "INSERT INTO orderdetails(detailID,quantity,orderID,prodID)values('$detailID',1,'$orderID','$prodID')";
						
				if (mysqli_query($conn, $insertOrderDetails)) 
				{
					echo "<script language='javascript'>
					alert('Product on current order has been add into the cart.');window.location='/FOODIE/student/search.php';</script>";
				} 
				else 
				{
					echo "Error: " . $insertOrderDetails . "<br>" . mysqli_error($conn);
				}
			}
			else
			{
				echo "<script language='javascript'>
				alert('Product ID has already existed.');</script>";
			}
		}
		else
		{
			echo "<script language='javascript'>
			alert('Detail ID has already existed.');</script>";
		}
		
	}
}

if(isset($_POST['another']))
{
	echo"<script language='javascript'>window.location='/FOODIE/student/search.php';</script>";
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
          <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Product ID</span>
                <span class="info-value"><?php echo $data['prodID'] ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Price</span>
                <span class="info-value"><?php echo $data['price'] ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Type Name</span>
                <span class="info-value"><?php echo $data['typeName'] ?></span>
            </div>
          </div>
          
          <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Product Name</span>
                <span class="info-value"><?php echo $data['prodName'] ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Description</span>
                <span class="info-value"><?php echo $data['prodDesc'] ?></span>
            </div>
          </div>
          
        </section>
        <form method="post">
          <div class="buttton-grid">
            <!--<button type="submit" name ="select" class="cart">Add To Cart 
              <img src="/FOODIE/images/cart.png" alt="" >
            </button>-->
            <button type="submit" name="another" class="other">Select Another Product
              <img src="/FOODIE/images/go_back.png" alt="">
            </button>
          </div>
          
        </form>
      </main>
    </div>
  </body>
</html>
