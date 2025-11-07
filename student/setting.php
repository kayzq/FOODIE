<?php
  session_start();
  include("studconnection.php");

  if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1) {
      header("Location:/FOODIE/landing-page/index.html");
  }

  $studID = $_SESSION['studID'];
  $sql = "SELECT * FROM students WHERE studID='$studID'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $studID = $row['studID'];
  $studName = $row['studName'];
  $studGender = $row['studGender'];
  $studPhoneNo = $row['studPhoneNo'];
  $matricNo = $row['MatricNo'];
  $studEmail = $row['studEmail'];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="setting.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>FOODIE - Settings</title>
  </head>

  <body>
    <div class="container">
      <aside class="sidebar">
        <div class="logo-container">
          <div class="logo">FOODIE.</div>
        </div>
        <nav class="nav-menu">
          <a href="home.php" class="nav-item">HOME</a>
          <a href="search.php" class="nav-item">SEARCH</a>
          <a href="receipts.html" class="nav-item">RECEIPTS</a>
          <a href="cart.html" class="nav-item">CART, DORM & DATES</a>
          <a href="adminContact.php" class="nav-item">ADMIN CONTACT</a>
          <a href="" class="nav-item active">SETTINGS</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="header-title">SETTINGS</header>

        <!-- User profile card -->
        <section class="profile-card-container">
          <div class="profile-card">
            <div class="profile-picture">
              <img src="https://placehold.co/100x100/7b002c/ffffff?text=User" alt="User Profile Picture" />
            </div>

            <div class="profile-info">

              <!-- STUDENT ID -->
              <p class="id">Student ID:</p>
              <p class="studID"><?php echo $studID; ?></p>

              <!-- NAME -->
              <div class="info-row">
                <h1>Name:</h1>
                <p><?php echo $studName; ?></p>
              </div>

              <!-- EMAIL -->
              <div class="info-row">
                <h1>Email:</h1>
                <p><?php echo $studEmail; ?></p>
                <button id="openModal">Edit</button>

                <div class="modal" id="modal">
                  <div class="modal-inner">
                    <button id="closePopup" class="close-btn">&times;</button>
                    <h1>EDIT EMAIL</h1>
                    <input type="email" id="popupInput" required placeholder="Enter new email" />
                    <p class="email-msg" style="font-size: 14px; margin-top: 8px;"></p>
                    <button id="closeModal">Save</button>
                  </div>
                </div>
              </div>

              <!-- PHONE NO -->
              <div class="info-row">
                <h1>Phone No:</h1>
                <p><?php echo $studPhoneNo; ?></p>
                <button id="openPhoneModal">Edit</button>
                <div class="modal" id="phoneModal">
                  <div class="modal-inner">
                    <button id="closePhonePopup" class="close-btn">&times;</button>
                    <h1>EDIT PHONE</h1>
                    <input type="text" id="phoneInput" placeholder="Enter new phone number" />
                    <button id="savePhoneBtn">Save</button>
                  </div>
                </div>
              </div>

              <!-- MATRIC NO -->
              <h1>Matric No:</h1>
              <p><?php echo $matricNo; ?></p>

              <!-- PASSWORD -->
              <h1>Password:</h1>
              <p>********</p>

              <p class="role">Student</p>
              <p class="gender"><?php echo $studGender; ?></p>
            </div>
          </div>
        </section>
      </main>
    </div>

    <script src="settingemail.js"></script>
    <script src="settingphone.js"></script>
  </body>
</html>
