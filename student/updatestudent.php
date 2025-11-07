<?php
include("studconnection.php");
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $studID = $_SESSION['studID'];
  $field = $_POST['field'];
  $value = $_POST['value'];

  $sql = "UPDATE students SET $field = '$value' WHERE studID = '$studID'";
  mysqli_query($conn, $sql);

  header("Location: setting.php");
  exit();
}
?>