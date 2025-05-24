<?php
include 'config.php';

$id = $_POST['id'];
$sql = "UPDATE users SET is_archived = 0 WHERE id = $id";
echo $conn->query($sql) ? 'success' : 'error';
$conn->close();
?>
