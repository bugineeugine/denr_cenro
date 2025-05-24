<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $db_username, $db_password, $role);
    $stmt->fetch();

    if (password_verify($password, $db_password)) {
      $_SESSION['user_id'] = $id;
      $_SESSION['username'] = $db_username;
      $_SESSION['role'] = $role;

      header("Location: admin-dashboard.html");
      exit();
    } else {
      echo "<script>alert('Invalid password.'); window.location='login.html';</script>";
    }
  } else {
    echo "<script>alert('User not found.'); window.location='login.html';</script>";
  }

  $stmt->close();
}
?>
