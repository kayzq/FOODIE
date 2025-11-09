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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title>Cart, Dorm & Dates</title>
  <link rel="stylesheet" href="cart.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="logo-container">
        <div class="logo">FOODIE.</div>
      </div>
      <nav class="nav-menu">
        <a href="home.php" class="nav-item">HOME</a>
        <a href="search.php" class="nav-item">SEARCH</a>
        <a href="receipts.html" class="nav-item">RECEIPTS</a>
        <a href="cart.php" class="nav-item active">CART, DORM & DATES</a>
        <a href="adminContact.php" class="nav-item">ADMIN CONTACT</a>
        <a href="setting.php" class="nav-item">SETTINGS</a>
        <a href="logout.php" class="nav-item">LOG OUT</a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <header class="header-title">CART, DORM & DATES</header>
      <h3 class="section-title">YOUR ORDER ID: <?php echo $_SESSION['orderID']; ?></h3>

      <!-- PRODUCT TABLE -->
      <div class="product-section">   
        <table border="0">
          <tr>
            <th>Detail ID</th>
            <th>Product Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Options</th>
          </tr>


          <?php
					
					$orderID = $_SESSION['orderID'];
					
					$sql = "SELECT * FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID
					INNER JOIN prodtypes t ON p.typeID = t.typeID WHERE od.orderID = '$orderID' ORDER BY od.detailID";
					
					$qry = mysqli_query($conn, $sql);
					$row = mysqli_num_rows($qry);

					if($row > 0)
					{
						
						while($r = mysqli_fetch_array($qry)) 
						{
						?>
          <tr>
           <td><?php echo $r['detailID']; ?></td>
								<td><?php echo $r['prodName']; ?></td>
								<td><?php echo $r['typeName']; ?></td>
								<td><?php echo "RM ", $r['price']; ?></td>
								<td><?php echo $r['quantity']; ?></td>
								<td><?php echo "RM ", number_format($r['price'] * $r['quantity'], 2);?></td>
						<td>	
              <a id="edit" href="editQCart.php?detailID=<?php echo $r['detailID']; ?>">
                <img src="/FOODIE/images/edit_icon.png" alt="Edit" class="icon-btn" />
              </a>
              <a id="del" onclick="return confirm('Delete this product?');" href="delete.php?detailID=<?php echo $r['detailID']; ?>">
                <img src="/FOODIE/images/trash_icon.png" alt="Delete" class="icon-btn" />
              </a>
            </td>
          </tr>

          <?php
            }
            ?>
          <?php
          } 
          else {
                echo "<tr><td colspan='8'>Empty cart :( .</td></tr> ";
            }
          ?>
        </table>
      </div>
        <form action="dateDorm.php" method="post">
      <!-- DATE & DORM INFO -->
      <div class="info-grid">
        <div class="info-section">
          <h3 class="section-title">DATE INFORMATION</h3>
          <p>Date Order:</p>
          <input id = "do" type="text" value="<?php 
								date_default_timezone_set("Asia/Kuala_Lumpur");
								echo date("d/m/Y"); 
							?>" readonly  ><br><br>

          <p>Date of Delivery:</p>
          <?php
							date_default_timezone_set("Asia/Kuala_Lumpur");
							$todayDate = date("Y-m-d"); //2020-11-03
						?>
          <input type="date" name="deliveryDate" id="deliveryDate" value="<?php echo $todayDate;?>">
        </div>

        <div class="info-section">
          <h3 class="section-title">DORM INFORMATION</h3>
          <p>Dorm Level:</p>
          <input type="number" placeholder="Enter level" name="dormLevel" id="dormLevel" min = "0" max = "10"><br><br>

          <p>Dorm Number:</p>
          <input type="number" name="dormNo" id="dormNo" min="1"  max = "326" placeholder="Enter room number"><br><br>

          <p>Building:</p>
              <select name="buildingID" id="buildingID" style="font-size:17px;">
                <option value="">-- Select Building --</option>
								<?php 
									$sqlbuildings = "SELECT * FROM buildings ORDER BY buildingName ASC";
									$qrybuildings = mysqli_query($conn, $sqlbuildings);
									$rowbuildings= mysqli_num_rows($qrybuildings);

									if($rowbuildings > 0)
									{
										while($dbuildings = mysqli_fetch_assoc($qrybuildings))
										{
											if($buildingID == $dbuildings['buildingID'])
												echo "<option value='".$dbuildings['buildingID']."'selected>".$dbuildings['buildingName']."</option>";
											else
												echo "<option value='".$dbuildings['buildingID']."'>".$dbuildings['buildingName']."</option>";
										}
									}
								?>
							</select>				
        </div>
      </div>

      <!-- buttons -->

      <div class="button-row">
        <?php
				if($_SESSION['logoutPermission'] == 0) //No
				{?>
        <button type='submit' id='checkout' name='checkout' title='Button to checkout order' class="checkout-btn">Checkout Order</button>
        <button type='submit' class="cancel-btn" id='cancel' name='cancel' onclick="return confirm('Cancel this order?');" title='Button to cancel order'>Cancel Order</button>
      <?php
				}
			?>
      </div>
    </form>
    </main>
  </div>
</body>
 <script>
	//jQuery for validate blank input
	$(document).ready(function()
	{
		$('#checkout').click(function()
		{
			var level = $("#dormLevel").val();
			var id = $("#buildingID").val();
			var no = $("#dormNo").val();
			var date = $("#deliveryDate").val();
			
			if(level == "10" && (id == "BD002" || id == "BD003"))
			{
				alert("Tun Teja building have only 9 level!");
				$('#dormLevel').css("background-color","#ffb3b3");
				return false;
			}
			else if (no == "" && level == "")
			{
				alert("Please fill all dorm fields!");
				$('#dormLevel').css("background-color","#ffb3b3");
				$('#dormNo').css("background-color","#ffb3b3");
				return false;
			}
			else if (no == "" || level == "")
			{
				if (no == "")
				{
					alert("Please fill Dorm Number fields!");
					$('#dormNo').css("background-color","#ffb3b3");
					return false;
				}
				else
				{
					alert("Please fill Dorm Level fields!");
					$('#dormLevel').css("background-color","#ffb3b3");
					return false;
				}
			}
			else if (date == "")
			{
				alert("Please choose delivery date!");
				$('#deliveryDate').css("background-color","#ffb3b3");
				return false;
			}
      else if (id == "") {
        alert("Please select a building!");
        $('#buildingID').css("background-color","#ffb3b3");
        return false;
      }
			else
			{
				return confirm('Checkout this order?');
			}
		});
		
		$('#dormLevel, #dormNo, #deliveryDate').focusout(function(){
			$('#dormLevel, #dormNo, #deliveryDate').css("background-color", "white");
		});
		
		$('#dormLevel, #dormNo, #deliveryDate').change(function(){
		   $('#dormLevel, #dormNo, #deliveryDate').css("background-color", "white");
		});
		
		$('#dormLevel, #dormNo, #deliveryDate').keyup(function(){
		   $('#dormLevel, #dormNo, #deliveryDate').css("background-color", "white");
		});
	});
</script>

</html>
