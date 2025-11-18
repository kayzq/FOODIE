  <?php
    session_start();
    include("adminconnection.php");

    if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
    {
        header("Location: /FOODIE/landing-page/index.html");
        exit();
    }
    
    
  ?>





  <!DOCTYPE html>
  <html>

    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width" />
      <link rel="stylesheet" href="adminSuper.css" />
      <title>Admin Contact</title>
    </head>

    <body>
      <div class="container">

        <aside class="sidebar">

          <!-- FOODIE LOGO -->
          <div class="logo-container">
            <div class="logo">FOODIE.</div>
          </div>
      
          <!-- SIDEBAR MENU -->
          <nav class="nav-menu">
            <a href="adminDashboard.php" class="nav-item">DASHBOARD</a>
            <a href="adminSuper.php" class="nav-item">SUPER ADMINS</a>
            <a href="adminProducts.php" class="nav-item">PRODUCTS</a>
            <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
            <a href="adminOrders.php" class="nav-item active">ORDERS</a>
            <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
          </nav>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
          <header class="header-title">LIST OF ADMIN</header>

          <?php
            $sql = "SELECT * FROM admins";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0)
            {
              while($row = mysqli_fetch_assoc($result))
              {
                $adminName = $row['adminName'];
                $adminPhoneNo = $row['adminPhoneNo'];
                $adminEmail = $row['adminEmail'];
                $username = $row['username'];
                $adminID = $row['adminID'];
                $adminGender = $row['adminGender'];
                $adminIcNo = $row['adminIcNo'];
                $isActive = $row['is_active'];
                $adminImages = $row['adminImage'];

                // Add color or style for inactive admins
                $sectionClass = $isActive ? "info-section" : "info-section inactive";
                $statusText = $isActive ? "Active" : "Inactive";

                echo '
                <section class="'.$sectionClass.'">
                  <div class="info-wrapper">
                    <div class="admin-img">
                      <img src="'.(!empty($row['adminImage']) 
                                  ? $row['adminImage'] 
                                  : '/FOODIE/images/adminsImages/default_admin.png'
                              ).'" />
                    </div>
                    <div class="info-grid">
                      <h3 class="section-title">
                        '.$adminName.'
                        <span class="status-badge '.$statusText.'">'.$statusText.'</span>
                      </h3>
                      <div class="info-item">
                        <span class="info-label">Admin Id</span>
                        <span class="info-value">'.$adminID.'</span>
                      </div>
                      <div class="info-item">
                        <span class="info-label">Admin Name</span>
                        <span class="info-value">'.$adminName.'</span>
                      </div>
                      <div class="info-item">
                        <span class="info-label">Admin Gender</span>
                        <span class="info-value">'.$adminGender.'</span>
                      </div>
                      <div class="info-item">
                        <span class="info-label">Phone No</span>
                        <span class="info-value">'.$adminPhoneNo.'</span>
                      </div>
                      <div class="info-item">
                        <span class="info-label">Username</span>
                        <span class="info-value">'.$username.'</span>
                      </div>
                      <div class="info-item">
                        <span class="info-label">IC NO</span>
                        <span class="info-value">'.$adminIcNo.'</span>
                      </div>
                      <div class="info-item">
                        <span class="info-label">Admin Email</span>
                        <span class="info-value">'.$adminEmail.'</span>
                      </div>
                      <div class="action-buttons">';
                        
                        // Edit button
                        echo '<a href="/FOODIE/staff/adminSuperEditAdmin2.php?adminID='.$adminID.'">
                                <img src="/FOODIE/images/edit_icon.png" alt="Edit" class="icon-btn" />
                              </a>';

                        // Deactivate / Reactivate button
                        if ($isActive) {
                          echo '<a onclick="return confirm(\'Deactivate this admin?\');"
                                  href="/FOODIE/staff/adminDeleteAdmin.php?adminID='.$adminID.'&action=deactivate">
                                  <img src="/FOODIE/images/trash_icon.png" alt="Deactivate Icon" class="icon-btn" />
                                </a>';
                        } else {
                          echo '<a onclick="return confirm(\'Reactivate this admin?\');"
                                  href="/FOODIE/staff/adminDeleteAdmin.php?adminID='.$adminID.'&action=activate">
                                  <img src="/FOODIE/images/restore_icon.png" alt="Reactivate Icon" class="icon-btn" />
                                </a>';
                        }

                echo '
                      </div>
                    </div> <!-- .info-grid -->
                  </div> <!-- .info-wrapper -->
                </section>';
              }
            }
            else
            {
              echo '<p>No admin contact information available.</p>';
            }
            ?>
        </main>

      </div>
    </body>
  </html>