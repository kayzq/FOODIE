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
    $studentName = $_POST["studName"];
    $studentGender = $_POST["studGender"];
    $studentPhone = $_POST["studPhoneNo"];
    $MatricNo = $_POST["MatricNo"];
    $IcNumber = $_POST["studIcNo"];
    $studentEmail = $_POST["studEmail"];
    $studentPassword = $_POST["password"];

    $update = "UPDATE students 
              SET studentName='$studName', studentGender='$studGender', studentPhone='$studPhoneNo', 
                  MatricNo='$MatricNo', IcNumber='$studIcNo', studentEmail='$studEmail', studentPassword='$password'
              WHERE studID='$studID'";
      
    $run = mysqli_query($conn, $update);

    if($run)
    {
      echo "<script language='javascript'>
      alert('Details of student have been updated successfully.');
      window.location='/FOODIE/student/setting.php';
      </script>";
    }
    else
    {
      echo "<script language='javascript'>
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
              <input type="hidden" id="studentID" name="studentID" value="<?php echo $row['studID'] ?>"/>
            </div>

            <div class="form-group">
              <label for="studentName">Student Name</label>
              <input type="text" id="studentName" name="studentName" value="<?php echo $row['studName'] ?>" placeholder="<?php echo $row['studName'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="studentGender">Gender</label>
              <input type="text" id="studentGender" name="studentGender" value="<?php echo $row['studGender'] ?>" placeholder="<?php echo $row['studGender'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="studentPhoneNo">Phone No</label>
              <input type="text" id="studentPhoneNo" name="studentPhoneNo" value="<?php echo $row['studPhoneNo'] ?>" placeholder="<?php echo $row['studPhoneNo'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>
            
            <div class="form-group">
              <label for="Matric No">Matric No</label>
              <input type="text" id="Matric No" name="Matric No" value="<?php echo $row['MatricNo'] ?>" placeholder="<?php echo $row['MatricNo'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="Student Ic Number">Ic Number</label>
              <input type="text" id="Student Ic Number" name="Student Ic Number" value="<?php echo $row['studIcNo'] ?>" placeholder="<?php echo $row['studIcNo'] ?>" maxlength="45" style="font-size:17px;"/>
            </div>

            <div class="form-group">
              <label for="studentEmail">Student Email</label>
              <input type="text" id="studentEmail" name="studentEmail" value="<?php echo $row['studEmail'] ?>" placeholder="<?php echo $row['studEmail'] ?>" maxlength="45" style="font-size:17px;"/>
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
