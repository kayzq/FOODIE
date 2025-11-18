<?php
session_start();
include("adminconnection.php");

// check if user logged in
if(!isset($_SESSION['userlogged']) || $_SESSION['userlogged'] != 1) {
    header("Location: /FOODIE/landing-page/index.html");
    exit();
}

if(isset($_POST["add"])) {
    // collect form data
    $adminName    = $_POST["adminName"];
    $adminGender  = $_POST["adminGender"];
    $adminEmail   = $_POST["adminEmail"];
    $adminPhoneNo = $_POST["adminPhoneNo"];
    $username     = $_POST["username"];
    $adminIcNo    = $_POST["adminIcNo"];
    $password = $_POST["password"];

    // Get the last adminID
    $result = mysqli_query($conn, "SELECT adminID FROM admins ORDER BY adminID DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    $lastID = $row['adminID']; // e.g. 'ADM04'

    // Generate next adminID
    $number = (int)substr($lastID, 3);   // get numeric part
    $number++;    // increment
    $newAdminID = "ADM" . str_pad($number, 2, "0", STR_PAD_LEFT); // e.g. ADM05

    $profileImage = "";

    // Handle image upload if exists
    if(!empty($_FILES['adminImage']['name'])) {

        $fileName = $_FILES['adminImage']['name'];
        $fileTmp = $_FILES['adminImage']['tmp_name'];
        $fileSize = $_FILES['adminImage']['size'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if(!in_array($ext, $allowed)) {
            echo "<script>alert('Invalid file type! Only JPG, PNG, GIF allowed.');history.back();</script>";
            exit;
        }

        if($fileSize > 2 * 1024 * 1024) {
            echo "<script>alert('File too large! Maximum size: 2MB');history.back();</script>";
            exit;
        }

        // New filename
        $random = rand(10000, 99999);
        $newName = "admin_" . $adminID . "_" . $random . "." . $ext;

        // REAL server directory
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/FOODIE/images/adminsImages/";
        $uploadPath = $targetDir . $newName;

        // URL to save in database
        $dbPath = "/FOODIE/images/adminsImages/" . $newName;

        // Move uploaded file
        if(move_uploaded_file($fileTmp, $uploadPath)) {
            $profileImage = $dbPath;
        } else {
            echo "<script>alert('Image upload failed!');history.back();</script>";
            exit;
        }
    }


    $insert = "INSERT INTO admins 
    (adminID, adminName, adminGender, adminEmail, adminPhoneNo, username, adminIcNo, password, adminImage)
    VALUES 
    ('$newAdminID', '$adminName', '$adminGender', '$adminEmail', '$adminPhoneNo', '$username', '$adminIcNo', '$password', '$profileImage')";



    $run = mysqli_query($conn, $insert);

    if($run) {
        echo "<script>alert('New admin added successfully!'); window.location='/FOODIE/staff/adminSuperChoose.html';</script>";
    } else {
        echo "<script>alert('Error: Failed to add new admin.');</script>";
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

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <header class="header-title">ADD AN ADMIN</header>
      <section class="info-section">
        <form method="POST" enctype="multipart/form-data">

          <div class="form-group">
            <label for="adminName">Admin Name</label>
            <input 
              type="text" 
              id="adminName" 
              name="adminName"
              maxlength="45"
              required
              pattern="^[A-Za-z][A-Za-z ]{1,44}$"
              oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
              placeholder="Admin Full Name"
              style="font-size:17px;"
            />
          </div>

          <div class="form-group">
            <label for="adminGender">Gender</label>
            <select id="adminGender" name="adminGender" required>
              <option value="">-- Choose Gender --</option>
              <option value="M">Male (M)</option>
              <option value="F">Female (F)</option>
            </select>
          </div>

          <div class="form-group">
            <label for="adminPhoneNo">Phone No</label>
            <input 
              type="text" 
              id="adminPhoneNo" 
              name="adminPhoneNo"
              required
              placeholder="01XXXXXXXX"
              maxlength="11"
              pattern="01[0-9]{8,9}"
              oninput="this.value = this.value.replace(/[^0-9]/g, '');"
              title="Phone number must start with 01 and be 10–11 digits long."
              style="font-size:17px;"
            />
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input 
              type="text" 
              id="username" 
              name="username"
              required
              minlength="5"
              maxlength="20"
              pattern="^[A-Za-z][A-Za-z0-9_]{4,19}$"
              oninput="this.value = this.value.replace(/[^A-Za-z0-9_]/g, '');"
              placeholder="username"
              style="font-size:17px;"
              title="Username must start with a letter and can contain letters, numbers, and underscores. Length: 5–20 characters."
            />
          </div>

          <div class="form-group">
            <label for="adminIcNo">Admin IC</label>
            <input 
              type="text" 
              id="adminIcNo" 
              name="adminIcNo"
              required
              maxlength="12"
              pattern="^[0-9]{12}$"
              oninput="this.value = this.value.replace(/[^0-9]/g, '');"
              placeholder="12-digit IC number"
              title="Please enter a valid 12-digit IC number."
              style="font-size:17px;"
            />
          </div>

          <div class="form-group">
            <label for="adminEmail">Admin Email</label>
            <input 
              type="email" 
              id="adminEmail" 
              name="adminEmail"
              required
              maxlength="45"
              placeholder="admin@example.com"
              title="Enter a valid email address, e.g., admin@example.com"
              style="font-size:17px;"
            />
          </div>

          <div class="form-group">
            <label for="password">Admin Password</label>
            <input 
              type="password" 
              id="password" 
              name="password"
              required
              minlength="6"
              maxlength="45"
              placeholder="Minimum 6 characters, 1 uppercase, 1 number, 1 symbol"
              style="font-size:17px;"
              pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':,.<>?]).{6,45}$"
              title="Password must be 6–45 characters, include at least 1 uppercase letter, 1 number, and 1 symbol."
            />
          </div>


          <div class="form-group">
            <label for="adminImage">Profile Picture</label>
            <input 
              type="file" 
              id="adminImage"
              name="adminImage"
              accept=".jpg, .jpeg, .png, .gif"
              style="font-size:17px;"
            />
          </div>

          <button type="submit" id="add" name="add" class="btn">
            Add Admin
            <img src="/FOODIE/images/check.png" alt="Select" width="18" height="18" />
          </button>

          <a class="btn-x" href="/FOODIE/staff/adminSuperChoose.html">
            Cancel
            <img src="/FOODIE/images/x_icon.png" alt="Select" width="14" height="14" />
          </a>

        </form>

      </section>
    </main>
  </div>
</body>
</html>
