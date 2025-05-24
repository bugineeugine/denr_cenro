<?php 

    include('../../config.php');

    header('Content-Type: application/json');
function archiveUser($conn, $id) {
    $id = $conn->real_escape_string($id);
    $sql = "UPDATE users SET is_archived = 1 WHERE id = '$id'";
    if ($conn->query($sql)) {
        return ['success' => true, 'message' => 'User archived successfully'];
    } else {
        return ['success' => false, 'message' => 'Error archiving user: ' . $conn->error];
    }
}



$userId = $_GET['id'];
$user = archiveUser($conn, $userId);
if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(['message' => 'User not found']);
}





?>