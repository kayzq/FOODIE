<?php
session_start();
include("adminconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
}

     $typeID = $_GET['typeID'];
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="adminAddProductFill.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="/FOODIE/staff/adminDashboard.html" class="nav-item active"
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

          <form id="form" action="add.php" method="POST">
            <div class="form-group">
              <label for="detailID">Detail ID</label>
             <input type="text" id="prodID" name="prodID" placeholder="eg: PD001" maxlength="5" style="font-size:17px;" readonly value=
					<?php
						$i = 1;
						while($i == 1)
						{
							$uniqId = substr(str_shuffle("0123456789"), 0, 3);

							$prodID = "PD".$uniqId;
							
							$sql = "SELECT prodID FROM products WHERE prodID='".$prodID."'";
							$qry=mysqli_query($conn,$sql);
							$row=mysqli_num_rows($qry);
								
							if($row > 0)
							{
								$i = 1;
							}
							else
							{
								$i = -1;
								echo $prodID;
							}
						}
					?>>
            </div>

            <div class="form-group">
              <label for="productName">Product Name</label>
              <input type="text" id="prodName" name="prodName" placeholder="eg: Butter cookies" maxlength="45" style="font-size:17px;" />
            </div>

            <div class="form-group">
              <label for="price">Price</label>
              <input type="number" id="input-1" name="price" placeholder="0.00" step="0.10" oninput="onInput(this)" value="1.00" min="1.00" max="99.99" style="font-size:17px;">
              <span style="color:red;"><strong style="color:red;">Choose the right price!</strong> The price cannot be changed after this.</span>
            </div>

            <script type="text/javascript">
					function onInput(event) 
					{
						let value = parseFloat(event.value);
						if (Number.isNaN(value)) 
						{
							document.getElementById('input-1').value = "0.00";
						} 
						else 
						{
							document.getElementById('input-1').value = value.toFixed(2);
						}              
					}	
			    </script>

            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" id="description" name="prodDesc" placeholder="eg: Butter cookies filled with chocolate" maxlength="45" style="font-size:17px;" />
            </div>

            <div class="form-group">
              <label for="productTypeID">Product type ID</label>
              <div class="product-type-row">
                <input
                  type="text"
                  id="productTypeID"
                  name="productTypeID"
                  class="product-type-input" value="<?php echo $typeID;?>" readonly style="font-size:17px;" 
                />
                <span class="product-type-options">
                  PT001 – Instants | PT002 – Sweets | PT003 – Biscuits
                </span>
              </div>
            </div>
          

          <button type="submit" id="add" name="Add" title="Button to add product into database" class="btn">Add product<img
              src="/FOODIE/images/check.png"
              alt="Select"
              width="14"
              height="14"
          /></button>
            

          <a class="btn-x" href="/FOODIE/staff/adminAddProduct.php"
            >Cancel<img
              src="/FOODIE/images/x_icon.png"
              alt="Select"
              width="14"
              height="14"
          /></a>
       </form>
        </section>
 
        <script>
	//jQuery for validate blank input
	$(document).ready(function()
	{
		$('#add').click(function()
		{
			var n = $("#prodName").val();
			
			if(n =='')
			{
				alert("Please fill Product Name fields!");
				$('#prodName').css("background-color","#ffb3b3");
				return false;
			}
			else
			{
				return confirm('Are you sure you want to add this product?')
			}
		});
		
		$('input[type="text"]').focusout(function(){
			$('input[type="text"]').css("background-color", "white");
		});
	});
</script>
      </main>
    </div>
  </body>
</html>
