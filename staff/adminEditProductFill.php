<?php

session_start();
include("adminconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
}

      $prodID = $_GET['prodID']; // get id through query string

      $qry = mysqli_query($conn,"SELECT * FROM products p INNER JOIN prodtypes pt ON p.typeID = pt.typeID WHERE prodID='$prodID'"); // select query

      $data = mysqli_fetch_array($qry); // fetch data

      if(isset($_POST['Update']))
        {
            $prodName = $_POST['prodName'];
            $price = $_POST['price'];
            $prodDesc = $_POST['prodDesc'];
            $typeID = $_POST['typeID'];

            // Folder path to store images
            $targetDir = "../images/";
            
            // Check if new file uploaded
            if(!empty($_FILES["prodImage"]["name"]))
            {
                $fileName = basename($_FILES["prodImage"]["name"]);
                $targetFilePath = $targetDir . $fileName;

                // Delete old image if exists
                if(!empty($data['images']) && file_exists($targetDir.$data['images'])){
                    unlink($targetDir.$data['images']);
                }

                // Upload new image to folder
                if(move_uploaded_file($_FILES["prodImage"]["tmp_name"], $targetFilePath)){
                    $update = "UPDATE products SET prodName='$prodName', price='$price', prodDesc='$prodDesc', typeID='$typeID', images='$fileName' WHERE prodID='$prodID'";
                } 
                else {
                    echo "<script>alert('Image upload failed!');</script>";
                }
            }
            else
            {
                // Update without changing image
                $update = "UPDATE products SET prodName='$prodName', price='$price', prodDesc='$prodDesc', typeID='$typeID' WHERE prodID='$prodID'";
            }

            $run = mysqli_query($conn, $update);

            if($run)
            {
                echo"<script>alert('Product updated successfully.');window.location='/FOODIE/staff/adminProducts.php';</script>";
            }
            else
            {
                echo"<script>alert('Error updating product.');window.location='/FOODIE/staff/adminProducts.php';</script>";
            }
        }


      if(isset($_POST['Cancel']))
      {
        echo"<script language='javascript'>history.back();</script>";
      }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="adminEditProductFill.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="adminDashboard.php" class="nav-item">DASHBOARD</a>
          <a href="adminSuper.php" class="nav-item">SUPER ADMINS</a>
          <a href="adminProducts.php" class="nav-item active">PRODUCTS</a>
          <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
          <a href="adminOrders.html" class="nav-item">ORDERS</a>
          <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">EDIT PRODUCT</header>

        <!-- Personal information section -->
        <section class="info-section">
          <h3 class="section-title">EDIT PRODUCT</h3>
        <form method="POST" class="product-form" enctype="multipart/form-data">
          
            <div class="form-group">
              <label for="detailID">Detail ID</label>
              <span><?php echo $data['prodID'] ?></span>
              <input type="hidden" id="detailID" name="detailID" value="<?php echo $data['prodID'] ?>"/>
            </div>

            <div class="form-group">
              <label for="productName">Product Name</label>
              <input type="text" id="name" name="prodName" value="<?php echo $data['prodName'] ?>" placeholder="<?php echo $data['prodName'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="price">Price</label>
              <input type="hidden" id="input-1" name="price" value="<?php echo $data['price'] ?>" style="font-size:17px;"><?php echo $data['price'] ?></input>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" name="prodDesc" id="desc" value="<?php echo $data['prodDesc'] ?>" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="description">Product picture</label>
              <img src="../images/<?php echo $data['images']; ?>" width="100" style="border-radius:10px;">

              <input type="file" name="prodImage" id="desc" accept=".jpg, .jpeg, .png, .gif" style="font-size:17px;" class="upload-label"/>
            </div>

            <div class="form-group">
              <label for="productTypeID">Product type ID</label>
              <div class="product-type-row">
               <select name="typeID" id="typeID" class="product-type-input"  style="height: 35px">
                
                      <?php 
                                  $sqlprodtypes = "SELECT * FROM prodtypes ORDER BY typeID ASC";
                                  $qryprodtypes = mysqli_query($conn, $sqlprodtypes);
                                  $rowprodtypes= mysqli_num_rows($qryprodtypes);
                
                                  if($rowprodtypes > 0)
                                  {
                                      while($dprodtypes = mysqli_fetch_assoc($qryprodtypes))
                                      {
                                          if($data['typeID'] == $dprodtypes['typeID'])
                                              echo "<option value='".$dprodtypes['typeID']."'selected>".$dprodtypes['typeName']." (".$dprodtypes['typeDesc'].")"."</option>";
                                          else
                                              echo "<option value='".$dprodtypes['typeID']."'>".$dprodtypes['typeName']." (".$dprodtypes['typeDesc'].")"."</option>";
                                        }
                                  }
                  ?>
            </select>
                <span class="product-type-options">
                  PT001 – Instants | PT002 – Sweets | PT003 – Biscuits
                </span>
              </div>
            </div>
         
        
          <button type="submit" id="Update" name="Update" title="Button to update details of product" class="btn"> Edit Product<img
              src="/FOODIE/images/check.png"
              alt="Select"
              width="18"
              height="18"
          /></button>
           

          <a class="btn-x" href="/FOODIE/staff/adminProducts.php"
            >Cancel<img
              src="/FOODIE/images/x_icon.png"
              alt="Select"
              width="14"
              height="14"
          /></a>
        </section>
         </form>
      </main>
   
    </div>
    <script>
	//jQuery for validate blank input
	$(document).ready(function()
	{
		$('#Update').click(function()
		{
			var n = $("#name").val();
			
			if(n =='')
			{
				alert("Please fill Product Name fields!");
				$('#name').css("background-color","#ffb3b3");
				return false;
			}
			else
			{
				return confirm('Are you sure you want to update this product?');
			}
		});
		
		$('input[type="text"]').focusout(function(){
			$('input[type="text"]').css("background-color", "white");
		});
	});
</script>
  </body>
</html>
