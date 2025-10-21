<?php

session_start();
include("connection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="listOfStaff_style.css" />
    <title>List of Staff | FOODIE</title>
  </head>

  <body>
    <div class="container">
      <!-- SIDEBAR -->
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="listOfStaff.php" class="nav-item active">STAFF</a>
          <a href="#" class="nav-item">STAFF STATISTICS</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="header-title">LIST OF STAFF</header>
        </header>
      </main>
    </div>
  </body>
</html>

