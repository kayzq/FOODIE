<?php

session_start();
include("connection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: login.php");
}


			
				$studID = $_SESSION['adminID'];
			
				$sql = "SELECT * FROM admins s WHERE s.adminID = '$adminID'";
				
				$qry = mysqli_query($conn, $sql);
				$row = mysqli_num_rows($qry);

				if($row > 0)
				{
					$r = mysqli_fetch_assoc($qry);} 
          
?>
          



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="home.css" />
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="#" class="nav-item active">HOME</a>
          <a href="#" class="nav-item">SEARCH</a>
          <a href="#" class="nav-item">RECEIPTS</a>
          <a href="#" class="nav-item">CART, DORM &amp; DATES</a>
          <a href="#" class="nav-item">ADMIN CONTACT</a>  
          <a href="logout.php" class="nav-item">LOG OUT</a>  
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">HOME</header>

        <!--User profile card-->
        <section class="profile-card-container">
          <div class="profile-card">
            <div class="profile-picture">
              <img
                src="https://placehold.co/100x100/7b002c/ffffff?text=User"
                alt="User Profile Picture"
              />
            </div>
            <div class="profile-info">
              <h2><?php 
              
              $adminID = $_SESSION['adminID'];
              $sql = "SELECT 
                  TRIM(
                    CASE
                      WHEN adminName LIKE '% BIN %' THEN SUBSTRING_INDEX(adminName, ' BIN ', 1)
                      WHEN adminName LIKE '% BINTI %' THEN SUBSTRING_INDEX(adminName, ' BINTI ', 1)
                      ELSE adminName
                    END
                  ) AS shortName
                FROM admins
                WHERE adminID = '$adminID'" ;
                $qry = mysqli_query($conn,$sql);
                $result = mysqli_fetch_assoc($qry)['shortName'];
                $shortname = ucwords(strtolower($result));
                echo $shortname;
                ?>
              </h2>
              <p class="role">ADMIN</p>
              <p class="gender"><?php if($r['adminGender'] == 'M'){echo "Male";}else echo "Female" ; ?></p>
            </div>
          </div>
        </section>

        <!-- personal information section-->
        <section class="info-section">
          <h3 class="section-title">PERSONAL INFORMATION</h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">NAME</span>
              <span class="info-value"><?php echo $r['adminName']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">ADMIN ID</span>
              <span class="info-value"><?php echo $r['adminID']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">GENDER</span>
              <spa class="info-value"><?php if($r['adminGender'] == 'M'){echo "MALE";}else echo "FEMALE" ; ?></spa>
            </div>
            <div class="info-item">
              <span class="info-label">Email Address</span>
              <span class="info-value"><?php echo $r['adminEmail']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Phone No</span>
              <span class="info-value"><?php echo $r['adminPhoneNo']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">IC NO</span>
              <span class="info-value"><?php echo $r['adminIcNo']; ?></span>
            </div>
          </div>
        </section>
        
        <!--STATISTIC SECTION-->
       
      </main>
    </div>
  </body>
</html>