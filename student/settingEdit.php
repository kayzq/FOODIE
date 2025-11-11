<?php
  session_start();
  include("studconnection.php");

  if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1)
  {
      header("Location: /FOODIE/landing-page/index.html");
  }

  $studID = $_SESSION['studID'];
  $sql = "SELECT * FROM students WHERE studID='$studID'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  if(isset($_POST["edit"]))
  {
    $studName = $_POST["studName"];
    $studGender = $_POST["studGender"];
    $studPhoneNo = $_POST["studPhoneNo"];
    $MatricNo = $_POST["MatricNo"];
    $studIcNo = $_POST["studIcNo"];
    $studEmail = $_POST["studEmail"];
    $password = $_POST["password"] ?? $row["password"]; // keeps old password if not edited

    $update = "UPDATE students 
               SET studName='$studName', studGender='$studGender', studPhoneNo='$studPhoneNo',
               MatricNo='$MatricNo', studIcNo='$studIcNo', studEmail='$studEmail', password='$password'
               WHERE studID='$studID'";

    $run = mysqli_query($conn, $update);

    if($run)
    {
      echo "<script>
      alert('Details of student have been updated successfully.');
      window.location='/FOODIE/student/setting.php';
      </script>";
    }
    else
    {
      echo "<script>x
      alert('Error! Failed to update details of student.');
      window.location='/FOODIE/student/settingEdit.php';
      </script>";
    }
  }

  if(isset($_POST['Cancel']))
  {
      echo "<script language='javascript'>history.back();</script>";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="settingEdit.css" />
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
          <a href="receipts.php" class="nav-item">RECEIPTS</a>
          <a href="cart.php" class="nav-item">CART, DORM & DATES</a>
          <a href="adminContact.php" class="nav-item">ADMIN CONTACT</a>
          <a href="" class="nav-item active">SETTINGS</a>
          <a href="logout.php" class="nav-item">LOG OUT</a>
        </nav>
      </aside>

      <!--MAIN CONTENT-->
      <main class="main-content">
        <header class="header-title">EDIT A STUDENT</header>
        <section class="info-section">
          <form method="POST">
            <div class="form-group">
              <label for="detailID">Student ID: </label>
              <span><?php echo $row['studID'] ?></span>
              <input type="hidden" id="studID" name="studID" value="<?php echo $row['studID'] ?>"/>
            </div>

            <div class="form-group">
              <label for="studentName">Student Name</label>
              <input type="text" id="studName" name="studName" 
                value="<?php echo $row['studName'] ?>" 
                placeholder="<?php echo $row['studName'] ?>"
                title="Please put characters not more than 255."
                maxlength="255"
                style="font-size:17px;"
                required
              />
            </div>

            <div class="form-group">
              <label for="studentGender">Gender</label>
              <select id="studGender" name="studGender">
                <option value="M" <?php if($row['studGender'] == 'M') echo 'selected'; ?>>Male</option>
                <option value="F" <?php if($row['studGender'] == 'F') echo 'selected'; ?>>Female</option>
              </select>
            </div>

            <div class="form-group">
              <label for="studentPhoneNo">Phone No</label>
              <input type="text" id="studPhoneNo" name="studPhoneNo"
                value="<?php echo $row['studPhoneNo']; ?>"
                placeholder="<?php echo $row['studPhoneNo']; ?>"
                title="Please enter a valid Malaysian phone number (e.g. 0123456789)"
                minlength="9"
                maxlength="11"
                required
                style="font-size:17px;"
              />
            </div>
            
            <div class="form-group">
              <label for="MatricNo">Matric No</label>
              <input type="text" id="MatricNo" name="MatricNo"
                value="<?php echo $row['MatricNo']; ?>"
                placeholder="<?php echo $row['MatricNo']; ?>"
                title="Matric number must be 3-12 letters or numbers (no spaces)"
                minlength="3"
                maxlength="12"
                required
                style="font-size:17px;"
              />
            </div>

            <div class="form-group">
              <label for="studIcNo">Ic Number</label>
              <input type="text" id="studIcNo" name="studIcNo"
                value="<?php echo $row['studIcNo']; ?>"
                placeholder="<?php echo $row['studIcNo']; ?>"
                title="IC number must be exactly 12 digits (e.g. 030405011234)"
                minlength="12"
                maxlength="12"
                required
                style="font-size:17px;"
              />
            </div>

            <div class="form-group">
              <label for="studentEmail">Student Email</label>
              <input type="email" id="studEmail" name="studEmail"
                value="<?php echo $row['studEmail'] ?>"
                placeholder="<?php echo $row['studEmail'] ?>"
                title="Please put characters not more than 255."
                maxlength="255"
                style="font-size:17px;"
                required
              />
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password"
                placeholder="Leave blank to keep current password"
                minlength="8"
                maxlength="255"
                style="font-size:17px;"
              />
            </div>

            <button type="submit" id="edit" name="edit" title="Button to update details of student" class="btn">
              Edit Student
              <img src="/FOODIE/images/check.png" alt="Select" width="18" height="18" />
            </button>

            <a class="btn-x" href="/FOODIE/student/setting.php">
              Cancel
              <img src="/FOODIE/images/x_icon.png" alt="Select" width="14" height="14" />
            </a>
          </form>
        </section>
      </main>
    </div>
  </body>
</html>
