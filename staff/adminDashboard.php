<?php

session_start();
include("adminconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: /FOODIE/landing-page/index.html");
}

				$username= $_SESSION['username'];
			
				$sql = "SELECT * FROM admins a WHERE username = '$username'";
				
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
    <link rel="stylesheet" href="adminDashboard.css" />
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="/FOODIE/staff/adminDashboard.php" class="nav-item active"
            >DASHBOARD</a
          >
          <a href="/FOODIE/staff/adminSuper.php" class="nav-item"
            >SUPER ADMINS</a
          >
          <a href="/FOODIE/staff/adminProducts.php" class="nav-item"
            >PRODUCTS</a
          >
          <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
          <a href="/FOODIE/staff/adminOrders.php" class="nav-item">ORDERS</a>
          <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">ADMIN'S DASHBOARD</header>

        <!-- Personal information section -->
        <section class="info-section">
          <h3 class="section-title">ADMIN'S PERSONAL INFORMATION</h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">NAME</span>
              <span class="info-value"><?php echo $r['adminName']; ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">IC NO</span>
              <span class="info-value"><?php echo $r['adminIcNo']?></span>
            </div>
            <div class="info-item">
              <span class="info-label">GENDER</span>
              <span class="info-value"><?php if($r['adminGender'] == 'M'){
                echo "MALE";} 
                else{
                  echo "FEMALE";
                }
              ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Email Address</span>
              <span class="info-value"><?php echo $r['adminEmail']?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Phone No</span>
              <span class="info-value"><?php echo $r['adminPhoneNo']?></span>
            </div>
            <div class="info-item">
              <span class="info-label">USERNAME</span>
              <span class="info-value"><?php echo $r['username']?></span>
            </div>
          </div>
        </section>

        <!--Statistics-->
        <section class="info-section">
          <h3 class="section-title">STATISTICS</h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">TOTAL<br />ALL STUDENTS</span>
              <span class="info-value-stat"><?php
							$sql = "SELECT COUNT(*) as cnt FROM students";
							$result = mysqli_query($conn, $sql);
							$count = mysqli_fetch_assoc($result)['cnt'];
							echo $count;
						?></span>
            </div>
            <div class="info-item">
              <span class="info-label">PROFITS</span>
              <span class="info-value-stat"><?php
						
							$adminID = $_SESSION['adminID'];
							
							$sql = "SELECT DISTINCT * FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID 
									INNER JOIN orders o ON od.orderID = o.orderID";
									
							$qry = mysqli_query($conn, $sql);
							$row = mysqli_num_rows($qry);
							
							$total = 0;
							if($row > 0)
							{	
								while($r = mysqli_fetch_array($qry))
								{
									$total = $total + ($r['price'] * $r['quantity']);
								}
							}
							echo "RM ".$total;
						?></span>
            </div>
            <div class="info-item">
              <span class="info-label">NEW ORDERS<br />TODAY</span>
              <span class="info-value-stat"><?php
							$adminID = $_SESSION['adminID'];
						
							$sql = "SELECT COUNT(*) as cnt FROM orders WHERE orderDate=CURRENT_DATE";
							$result = mysqli_query($conn, $sql);
							$count = mysqli_fetch_assoc($result)['cnt'];
							echo $count;
						?></span>
            </div>
          </div>
        </section>

        <!--Number of Products Sold-->
        <section class="info-section">
          <h3 class="section-title">
            Number of Products Sold According to Product Types
          </h3>
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">Instant</span>
              <span class="info-value-stat">
                
                <?php
					
						
					
						$sql = "SELECT * FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID 
								INNER JOIN prodtypes pt ON p.typeID = pt.typeID INNER JOIN orders o ON od.orderID = o.orderID 
								WHERE pt.typeID = 'PT001'";

						$qry = mysqli_query($conn, $sql);
						$row = mysqli_num_rows($qry);
						
						$sum = 0;
						if($row > 0)
						{
							while($r = mysqli_fetch_array($qry))
							{
								$sum = $sum + $r['quantity'];
							}
						}
						echo $sum;
					?>
              </span>
            </div>
            <div class="info-item">
              <span class="info-label">Sweet</span>
              <span class="info-value-stat">
                <?php
					
					
					
						$sql = "SELECT * FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID 
								INNER JOIN prodtypes pt ON p.typeID = pt.typeID INNER JOIN orders o ON od.orderID = o.orderID 
								WHERE pt.typeID = 'PT002'";

						$qry = mysqli_query($conn, $sql);
						$row = mysqli_num_rows($qry);
						
						$sum = 0;
						if($row > 0)
						{
							while($r = mysqli_fetch_array($qry))
							{
								$sum = $sum + $r['quantity'];
							}
						}
						echo $sum;
					?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Biscuits</span>
              <span class="info-value-stat"><?php
					
					
						$sql = "SELECT * FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID 
								INNER JOIN prodtypes pt ON p.typeID = pt.typeID INNER JOIN orders o ON od.orderID = o.orderID 
								WHERE  pt.typeID = 'PT003'";

						$qry = mysqli_query($conn, $sql);
						$row = mysqli_num_rows($qry);
						
						$sum = 0;
						if($row > 0)
						{
							while($r = mysqli_fetch_array($qry))
							{
								$sum = $sum + $r['quantity'];
							}
						}
						echo $sum;
					?></span>
            </div>
          </div>
          <p>Total of All Products Sold: <?php
				
					$adminID = $_SESSION['adminID'];
				
					$sql = "SELECT * FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID 
							INNER JOIN prodtypes pt ON p.typeID = pt.typeID INNER JOIN orders o ON od.orderID = o.orderID 
							";

					$qry = mysqli_query($conn, $sql);
					$row = mysqli_num_rows($qry);
					
					$sum = 0;
					if($row > 0)
					{
						while($r = mysqli_fetch_array($qry))
						{
							$sum = $sum + $r['quantity'];
						}
					}
					echo $sum;
				?></p>
        </section>

        <!--Total Sales-->
        <section class="info-section">
          <h3 class="section-title">Total Sales In October 2025</h3>
          <?php 
					
						$adminID = $_SESSION['adminID'];
					
                $sql ="SELECT DAY(o.orderDate) AS day, MONTH(o.orderDate) AS month, SUM(p.price*od.quantity) AS totalPrice 
                FROM orderdetails od INNER JOIN products p ON od.prodID = p.prodID INNER JOIN orders o ON od.orderID = o.orderID 
                WHERE MONTH(o.orderDate) = MONTH(CURRENT_DATE)  GROUP BY o.orderDate, DAY(o.orderDate), MONTH(o.orderDate)";
						
						$salesW1 = 0;
						$salesW2 = 0;
						$salesW3 = 0;
						$salesW4 = 0;
						$salesOtherDays = 0;
						
						$result = mysqli_query($conn,$sql);
						$chart_data="";
						while ($row = mysqli_fetch_array($result))
						{
							if ($row['day'] >= 1 && $row['day'] <= 7) //W1
								$salesW1 = $salesW1 + $row['totalPrice'];
							else if ($row['day'] >= 8 && $row['day'] <= 14) //w2
								$salesW2 = $salesW2 + $row['totalPrice'];
							else if ($row['day'] >= 15 && $row['day'] <= 21) //W3
								$salesW3 = $salesW3 + $row['totalPrice'];
							else if ($row['day'] >= 22 && $row['day'] <= 28) //W4
								$salesW4 = $salesW4 + $row['totalPrice'];
							else
								$salesOtherDays = $salesOtherDays + $row['totalPrice']; #Day 29/30/31
						}
						$weeklySales[]  = $salesW1;
						$weeklySales[]  = $salesW2;
						$weeklySales[]  = $salesW3;
						$weeklySales[]  = $salesW4;
						$weeklySales[]  = $salesOtherDays;  
					?>
					<div style="text-align:center;">
					<h2 class="page-header" >

					</h2>
					<canvas  id="chartjs_bar"></canvas>  
					<!-- jQuery -->
					<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
					<!-- ChartJS -->
					<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
					<script type="text/javascript">
						var ctx = document.getElementById("chartjs_bar").getContext('2d');
							var myChart = new Chart(ctx, 
							{
								type: 'bar',
								data: 
								{
									labels  : ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Day 29 | 30 | 31'],
									datasets: 
									[
									{
										label: 'Total Sales',
										backgroundColor     : 'rgba(60,141,188,0.9)',
										borderColor         : 'rgba(60,141,188,0.8)',
										pointRadius          : false,
										pointColor          : '#3b8bba',
										pointStrokeColor    : 'rgba(60,141,188,1)',
										pointHighlightFill  : '#fff',
										pointHighlightStroke: 'rgba(60,141,188,1)',
										barThickness: 100,
										data                : <?php echo json_encode($weeklySales); ?>,
									},
									]
								},
							options: {
                plugins: {
                  legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                      color: '#71748d',
                      font: {
                        family: 'Circular Std Book',
                        size: 14
                      }
                    }
                  }
                },
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }

						});
					</script>
        </section>

        
                  <!--Total Monthly Sales-->
          <section class="info-section">
            <h3 class="section-title">Total Sales by Month (All Time)</h3>
            <?php 
              $adminID = $_SESSION['adminID'];
              
              // ✅ Query: total sales grouped by month and year
              $sqlMonthly = "SELECT 
                              MONTH(o.orderDate) AS month,
                              YEAR(o.orderDate) AS year,
                              SUM(p.price * od.quantity) AS totalPrice
                            FROM orderdetails od
                            INNER JOIN products p ON od.prodID = p.prodID
                            INNER JOIN orders o ON od.orderID = o.orderID  
                            GROUP BY YEAR(o.orderDate), MONTH(o.orderDate)
                            ORDER BY YEAR(o.orderDate), MONTH(o.orderDate) ASC";

              $resultMonthly = mysqli_query($conn, $sqlMonthly);

              // ✅ Separate variables to avoid conflict
              $monthlyLabels = [];
              $monthlySales = [];

              // Month names for better readability
              $monthNames = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
                7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
              ];

              while ($row = mysqli_fetch_assoc($resultMonthly)) {
                $monthName = $monthNames[$row['month']];
                $monthlyLabels[] = $monthName . ' ' . $row['year']; // e.g., "Jan 2025"
                $monthlySales[] = $row['totalPrice'];
              }
            ?>

            <div style="text-align:center;">
              <canvas id="chartjs_monthly"></canvas>  

              <!-- ChartJS -->
              <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>

              <script type="text/javascript">
                const ctxMonthly = document.getElementById("chartjs_monthly").getContext('2d');
                const monthlyChart = new Chart(ctxMonthly, {
                  type: 'bar',
                  data: {
                    labels: <?php echo json_encode($monthlyLabels); ?>, // e.g., ["Jan 2024", "Feb 2024", ...]
                    datasets: [{
                      label: 'Total Sales (RM)',
                      backgroundColor: 'rgba(60,141,188,0.9)',
                      borderColor: 'rgba(60,141,188,0.8)',
                      borderWidth: 1,
                      barThickness: 50,
                      data: <?php echo json_encode($monthlySales); ?>,
                    }]
                  },
                  options: {
                    plugins: {
                      legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                          color: '#71748d',
                          font: { family: 'Circular Std Book', size: 14 }
                        }
                      },
                      title: {
                        display: true,
                        text: 'Monthly Sales Overview',
                        color: '#333',
                        font: { size: 18, family: 'Circular Std Book' }
                      }
                    },
                    scales: {
                      y: { 
                        beginAtZero: true,
                        title: { display: true, text: 'Sales (RM)' }
                      },
                      x: { 
                        title: { display: true, text: 'Month and Year' }
                      }
                    }
                  }
                });
              </script>
            </div>
          </section>


        <!--Total Annual Sales-->
        <section class="info-section">
          <h3 class="section-title">Total Sales by Year (All Time)</h3>
          <?php 
            $adminID = $_SESSION['adminID'];
            
            // ✅ Query: total sales grouped by year
            $sqlAnnual = "SELECT 
                            YEAR(o.orderDate) AS year,
                            SUM(p.price * od.quantity) AS totalPrice
                          FROM orderdetails od
                          INNER JOIN products p ON od.prodID = p.prodID
                          INNER JOIN orders o ON od.orderID = o.orderID
                          GROUP BY YEAR(o.orderDate)
                          ORDER BY YEAR(o.orderDate) ASC";

            $resultAnnual = mysqli_query($conn, $sqlAnnual);

            // ✅ Separate variables to avoid clash with weekly sales
            $annualYears = [];
            $annualSales = [];

            while ($row = mysqli_fetch_assoc($resultAnnual)) {
              $annualYears[] = $row['year'];           // e.g. 2023, 2024, 2025
              $annualSales[] = $row['totalPrice'];     // Total sales for that year
            }
          ?>

          <div style="text-align:center;">
            <canvas id="chartjs_annual"></canvas>  

            <!-- ChartJS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>

            <script type="text/javascript">
              const ctxAnnual = document.getElementById("chartjs_annual").getContext('2d');
              const annualChart = new Chart(ctxAnnual, {
                type: 'bar',
                data: {
                  labels: <?php echo json_encode($annualYears); ?>, // x-axis: years
                  datasets: [{
                    label: 'Total Sales (RM)',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    borderWidth: 1,
                    barThickness: 80,
                    data: <?php echo json_encode($annualSales); ?>, // y-axis: totals
                  }]
                },
                options: {
                  plugins: {
                    legend: {
                      display: true,
                      position: 'bottom',
                      labels: {
                        color: '#71748d',
                        font: { family: 'Circular Std Book', size: 14 }
                      }
                    },
                    title: {
                      display: true,
                      text: 'Annual Sales Overview',
                      color: '#333',
                      font: { size: 18, family: 'Circular Std Book' }
                    }
                  },
                  scales: {
                    y: { 
                      beginAtZero: true,
                      title: { display: true, text: 'Sales (RM)' }
                    },
                    x: { 
                      title: { display: true, text: 'Year' }
                    }
                  }
                }
              });
            </script>
          </div>
        </section>


      </main>
    </div>
  </body>
</html>
