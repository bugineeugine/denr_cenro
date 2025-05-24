<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "permit_verification_system"; // use your DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$role = $_POST['role'];

$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $password, $role);

if ($stmt->execute()) {
  echo "Registration successful!";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
