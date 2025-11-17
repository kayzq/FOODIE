<?php
  session_start();
  include("studconnection.php");

  if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1) {
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
    $password = !empty($_POST["password"]) ? $_POST["password"] : $row["password"]; // keep old password

    $user_image = $row["user_image"]; // current image filename

    // Check if a new image is uploaded
    if(!empty($_FILES['user_image']['name']))
    {
      $fileName = $_FILES['user_image']['name'];
      $fileTmp = $_FILES['user_image']['tmp_name'];
      $fileSize = $_FILES['user_image']['size'];

      $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $allowed = ['jpg','jpeg','png','gif'];

      // Validate extension
      if(!in_array($ext, $allowed))
      {
        echo "<script>alert('Invalid file type! Only JPG, PNG, GIF allowed.');history.back();</script>";
        exit;
      }

      // Validate size (max 2MB)
      if($fileSize > 2 * 1024 * 1024)
      {
        echo "<script>alert('File too large! Maximum size: 2MB');history.back();</script>";
        exit;
      }

      // New filename
      $newName = "student_" . time() . "." . $ext;

      // Correct server path to save the file
      $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/FOODIE/images/studentImages/";
      $uploadPath = $uploadDir . $newName;

      // Move uploaded file
      if(move_uploaded_file($fileTmp, $uploadPath))
      {
        $user_image = $newName; // update filename to store in DB
      }
          
      else
      {
        echo "<script>alert('Failed to upload image.');history.back();</script>";
        exit;
      }
    }

    // Update the student record
    $update = "UPDATE students 
               SET studName='$studName', studGender='$studGender', studPhoneNo='$studPhoneNo',
                  MatricNo='$MatricNo', studIcNo='$studIcNo', studEmail='$studEmail', password='$password', 
                 user_image='$user_image'
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
      echo "<script>
              alert('Error! Failed to update details of student.');
              window.location='/FOODIE/student/settingEdit.php';
            </script>";
    }
  }

  if(isset($_POST['Cancel']))
  {
      echo "<script>history.back();</script>";
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
            <a href="setting.php" class="nav-item active">SETTINGS</a>
            <a href="logout.php" class="nav-item">LOG OUT</a>
          </nav>
        </aside>

        <!--MAIN CONTENT-->
        <main class="main-content">
          <header class="header-title">EDIT A STUDENT</header>
          <section class="info-section">
            <form method="POST" enctype="multipart/form-data">
              <!--STUDENT ID-->
              <div class="form-group">
                <label for="detailID">Student ID: </label>
                <span><?php echo $row['studID'] ?></span>
                <input type="hidden" id="studID" name="studID" value="<?php echo $row['studID'] ?>"/>
              </div>

              <!--PROFILE PICTURE-->
              <div class="form-group">
                <label for="user_image">Cuurent Pic:</label>
                <div class="profile-pic-container">
                  <!-- Show current image -->
                  <img 
                    src="/FOODIE/images/studentImages/<?php echo !empty($row['user_image']) ? $row['user_image'] : 'default_student.png'; ?>" 
                    alt="Current Profile Picture" 
                  />
                  <!-- File input to upload new image -->
                  <input 
                    type="file" 
                    id="user_image" 
                    name="user_image"
                    accept=".jpg, .jpeg, .png, .gif"
                    style="font-size:17px;"
                  />
                </div>
              </div>

              <!--STUDENT NAME-->
              <div class="form-group">
                <label for="studentName">Student Name</label>
                <input type="text" id="studName" name="studName" 
                  value="<?php echo $row['studName'] ?>" 
                  placeholder="Enter your full name"
                  maxlength="255" 
                  pattern="[A-Za-z@'\s]+"
                  title="Name can contain letters, spaces, @, and ' only"
                  required
                  style="font-size:17px;"
                />
              </div>

              <!--GENDER-->
              <div class="form-group">
                <label for="studentGender">Gender</label>
                <select id="studGender" name="studGender">
                  <option value="M" <?php if($row['studGender'] == 'M') echo 'selected'; ?>>Male</option>
                  <option value="F" <?php if($row['studGender'] == 'F') echo 'selected'; ?>>Female</option>
                </select>
              </div>

              <!--PHONE NUMBER-->
              <div class="form-group">
                <label for="studentPhoneNo">Phone No</label>
                <input type="text" id="studPhoneNo" name="studPhoneNo"
                  value="<?php echo $row['studPhoneNo']; ?>"
                  placeholder="e.g 0123456789"
                  minlength="9"
                  maxlength="11"
                  pattern="\d+"
                  title="Enter 9-11 digits, e.g., 012345678 or 01123456789"
                  required
                  style="font-size:17px;"
                />
              </div>
              
              <!--MATRIC NUMBER-->
              <div class="form-group">
                <label for="MatricNo">Matric No</label>
                <input type="text" id="MatricNo" name="MatricNo"
                  value="<?php echo $row['MatricNo']; ?>"
                  placeholder="e.g. A123"
                  minlength="3"
                  maxlength="12"
                  pattern="[A-Za-z0-9]+"
                  title="Enter 3-20 characters, letters and numbers only, e.g., A123" 
                  required
                  style="font-size:17px;"
                />
              </div>

              <!--IC NUMBER-->
              <div class="form-group">
                <label for="studIcNo">Ic Number</label>
                <input type="text" id="studIcNo" name="studIcNo"
                  value="<?php echo $row['studIcNo']; ?>"
                  placeholder="e.g. 990101123456"
                  minlength="12"
                  maxlength="12"
                  pattern="\d+"
                  title="Enter exactly 12 digits, e.g., 990101123456"
                  required
                  style="font-size:17px;"
                />
              </div>

              <!--STUDENT EMAIL-->
              <div class="form-group">
                <label for="studentEmail">Student Email</label>
                <input type="email" id="studEmail" name="studEmail"
                  value="<?php echo $row['studEmail'] ?>"
                  placeholder="e.g. Student123@gmail.com"
                  maxlength="255"
                  title="Please put characters not more than 255."
                  style="font-size:17px;"
                  required
                />
              </div>

              <!--PASSWORD-->
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                  placeholder="Leave blank to keep current password"
                  minlength="8"
                  maxlength="30"
                  pattern="(?=.*[A-Z])(?=.*\d)[^\s]+"
                  title="Password must include at least 1 uppercase letter, 1 digit, and no spaces" 
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
