<?php 
    include('../../config.php');

    header('Content-Type: application/json');
function getUserById($conn, $id) {
    $id = $conn->real_escape_string($id);
    $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


$userId = $_GET['id'];
$user = getUserById($conn, $userId);
if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(['message' => 'User not found']);
}

?>