<?php
session_start();
include("adminconnection.php");

// Check if user is logged in as normal admin first
if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1) {
    header("Location: /FOODIE/landing-page/index.html");
    exit();
}

// Define the super admin password (you can also store this in the DB instead)
$superAdminPassword = "123"; // <-- change this securely

// When the form is submitted
if(isset($_POST['login'])) {
    $enteredPassword = $_POST['password'];

    if($enteredPassword === $superAdminPassword) {
        // Grant super admin access
        $_SESSION['superadmin'] = true;
        echo "<script>alert('Super Admin access granted!'); window.location='/FOODIE/staff/adminSuperChoose.html';</script>";
    } else {
        echo "<script>alert('Incorrect password. Access denied.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="adminSuper.css" />
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="adminDashboard.php" class="nav-item">DASHBOARD</a>
          <a href="adminSuper.php" class="nav-item active">SUPER ADMINS</a>
          <a href="adminProducts.php" class="nav-item">PRODUCTS</a>
          <a href="adminAddProduct.php" class="nav-item">ADD PRODUCTS</a>
          <a href="adminOrders.php" class="nav-item">ORDERS</a>
          <a href="/FOODIE/staff/logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">SUPER ADMIN ACCESS</header>

        <!-- personal information section-->
        <section class="info-section">
          <h3 class="section-title">ENTER SUPER ADMIN PASSWORD</h3>

          <div class="login-container">
            <form class="login-form" method="POST">
              <label for="password">PASSWORD</label>
              <input
                type="password"
                id="password"
                name="password"
                class="password-input"
                required
              />

              <button type="submit" name="login" class="btn">LOGIN</button>
            </form>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>
