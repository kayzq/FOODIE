<?php
session_start();

include("studconnection.php"); 

if (isset($_POST['btnRegister'])) {
    $email     = trim($_POST['email']);
    $name      = trim($_POST['name']);
    $icNo      = trim($_POST['icNo']);
    $matricId  = trim($_POST['matricId']);
    $phoneNo   = trim($_POST['phoneNo']);
    $gender    = trim($_POST['gender']);
    $password1 = trim($_POST['password']);
    $password2 = trim($_POST['confirmPassword']);

    if (empty($email) || empty($name) || empty($icNo) || empty($matricId) ||
        empty($phoneNo) || empty($gender) || $gender == 'Choose' ||
        empty($password1) || empty($password2)) {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit;
    }

    // Verify password match
    if ($password1 !== $password2) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Check if matric ID or email already exists
    $check = "SELECT * FROM students WHERE MatricNo='$matricId' OR studEmail='$email'";
    $result = mysqli_query($conn, $check);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Matric ID or Email already registered!'); window.history.back();</script>";
        exit;
    }

    // Insert new record (plain password)
    $insert = "INSERT INTO students (studEmail, studName, studIcNo, MatricNo, studPhoneNo, studGender, password)
               VALUES ('$email', '$name', '$icNo', '$matricId', '$phoneNo', '$gender', '$password1')";

    if (mysqli_query($conn, $insert)) {
        echo "<script>
                alert(' Registration successful!');
                window.location.href = 'login.html';
              </script>";
    } else {
        echo "<script>
                alert('Registration failed: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
}
?>
