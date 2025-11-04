<?php

session_start();
include("adminconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="adminProducts.css" />
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="adminDashboard.php" class="nav-item">DASHBOARD</a>
          <a href="adminSuper.html" class="nav-item">SUPER ADMINS</a>
          <a href="adminProducts.html" class="nav-item active">PRODUCTS</a>
          <a href="adminAddProduct.html" class="nav-item">ADD PRODUCTS</a>
          <a href="adminOrders.html" class="nav-item">ORDERS</a>
          <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">PRODUCTS</header>

        <table border="0">
        <tr>
          <th>Detail ID</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Description</th> 
          <th>Type</th> 
          <th>options </th> 
        </tr>

        <?php
			
				$sql = "SELECT * FROM products p INNER JOIN prodtypes t ON p.typeID = t.typeID ORDER BY p.prodID";
				
				$qry = mysqli_query($conn, $sql);
				$row = mysqli_num_rows($qry);

				if($row > 0)
				{
					while($r = mysqli_fetch_array($qry)) 
					{?>
						<tr>
							<td><?php echo $r['prodID']; ?></td>
							<td><?php echo $r['prodName']; ?></td>
							<td><?php echo $r['price']; ?></td>
							<td><?php echo $r['prodDesc']; ?></td>
							<td><?php echo $r['typeName']; ?></td>
							<td>
              
                <a href="adminEditProductFill.html?prodID=<?php echo $r['prodID']; ?>">
                  <img
                    src="/FOODIE/images/edit_icon.png"
                    alt="Edit Icon"
                    class="icon-btn"
                  />
                </a>
                <a  onclick="return confirm('Delete this product?');"
							href="delete.php?prodID=<?php echo $r['prodID']; ?>">
                  <img
                    src="/FOODIE/images/trash_icon.png"
                    alt="Delete Icon"
                    class="icon-btn"
                  />
                </a>
              
            </td>
        </tr>
            <?php
          }
          ?>

        <p>Total Product(s): <?php echo $row ?></p>

        <?php
        }
        else{?>
           <p>Total Product(s): 0</p>
        <?php
        }
        ?>
      </main>
    </div>
  </body>
</html>
