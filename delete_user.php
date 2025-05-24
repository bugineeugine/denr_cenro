<?php
include 'config.php';

$id = $_POST['id'];
$sql = "DELETE FROM users WHERE id = $id";
echo $conn->query($sql) ? 'success' : 'error';
$conn->close();
?>
