<?php

session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: login.php");
}


			
				$studID = $_SESSION['studID'];
			
				$sql = "SELECT * FROM students s WHERE s.studID = '$studID'";
				
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
              
              $studID = $_SESSION['studID'];
              $sql = "SELECT 
                  TRIM(
                    CASE
                      WHEN studName LIKE '% BIN %' THEN SUBSTRING_INDEX(studName, ' BIN ', 1)
                      WHEN studName LIKE '% BINTI %' THEN SUBSTRING_INDEX(studName, ' BINTI ', 1)
                      ELSE studName
                    END
                  ) AS shortName
                FROM students
                WHERE studID = '$studID'" ;
                $qry = mysqli_query($conn,$sql);
                $result = mysqli_fetch_assoc($qry)['shortName'];
                $shortname = ucwords(strtolower($result));
                echo $shortname;
                ?>
              </h2>
              <p class="role">Student</p>
              <p class="gender"><?php if($r['studGender'] == 'M'){echo "Male";}else echo "Female" ; ?></p>
            </div>
          </div>
        </section>

        <!-- personal information section-->
        <section class="info-section">
          <h3 class="section-title">PERSONAL INFORMATION</h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">NAME</span>
              <span class="info-value"><?php echo $r['studName']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">IC NO</span>
              <span class="info-value"><?php echo $r['studIcNo']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">GENDER</span>
              <spa class="info-value"><?php if($r['studGender'] == 'M'){echo "MALE";}else echo "FEMALE" ; ?></spa>
            </div>
            <div class="info-item">
              <span class="info-label">Email Address</span>
              <span class="info-value"><?php echo $r['studEmail']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Phone No</span>
              <span class="info-value"><?php echo $r['studPhoneNo']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Matric No</span>
              <span class="info-value"><?php echo $r['MatricNo']; ?></span>
            </div>
          </div>
        </section>
        
        <!--STATISTIC SECTION-->
        <section class="statistic-section">
          <h3 class="section-title">STATISTIC</h3>
          <div class="stats-grid">
            <div class="stat-item">
              <span class="stat-label">PRODUCT PURCHASED</span>
              <span class="stat-value">
                <?php
							$studID = $_SESSION['studID'];
						
							$sql = "SELECT DISTINCT COUNT(od.detailID) as cnt FROM orderdetails od 
							INNER JOIN orders o ON od.orderID = o.orderID WHERE o.studID='$studID'";

							$qry = mysqli_query($conn, $sql);
							$count = mysqli_fetch_assoc($qry)['cnt'];
							echo $count;?>
						</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">ORDERS MADE</span>
              <span class="stat-value"><?php
						
							$studID = $_SESSION['studID'];
							
							$sql = "SELECT COUNT(*) as cnt FROM orders WHERE studID='$studID'";
							$result = mysqli_query($conn, $sql);
							$count = mysqli_fetch_assoc($result)['cnt'];
							echo $count;?>
						</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">TOTAL STUDENTS</span>
              <span class="stat-value">
              <?php
							$sql = "SELECT COUNT(*) as cnt FROM students";
							$result = mysqli_query($conn, $sql);
							$count = mysqli_fetch_assoc($result)['cnt'];
							echo $count;?>
						</span>
            </div>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>