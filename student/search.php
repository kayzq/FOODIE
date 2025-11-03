
<?php

session_start();
include("studconnection.php");

if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
{
    header("Location:/FOODIE/landing-page/index.html");
}

if (!isset($_SESSION['orderID']) || $_SESSION['orderID'] != "")
{
	header("Location: searchprod.php");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="searchStyle.css" />
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">  
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="home.php" class="nav-item">HOME</a>
          <a href="#" class="nav-item">SEARCH</a>
          <a href="#" class="nav-item">RECEIPTS</a>
          <a href="#" class="nav-item">CART, DORM &amp; DATES</a>
          <a href="adminContact.php" class="nav-item active">ADMIN CONTACT</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">Search</header>
        <div class="card"><h3>Search with FOODIE!</h3>
            </div>
        <!-- personal information section-->
        <section class="info-section">
           
            
          <form id="startSearch" name="startSearch" method="post" action="searchgen.php">
					  <input type="submit" class="btn" name="btnstart" value="Start Search"></form>
				  </form>
      </section>
      </main>
    </div>
  </body>
</html>
