<?php 
include('../../config.php');
header('Content-Type: application/json');

function deleteUser($conn, $id) {
    $id = $conn->real_escape_string($id);

    // First check if user has permits
    $checkSql = "SELECT COUNT(*) as cnt FROM permits WHERE holder_name = '$id'";
    $result = $conn->query($checkSql);
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['cnt'] > 0) {
            return ['success' => false, 'message' => 'Cannot delete user: User has active permits.'];
        }
    } else {
        return ['success' => false, 'message' => 'Error checking permits: ' . $conn->error];
    }

    // If no permits found, delete user
    $sql = "DELETE FROM users WHERE id = '$id'";
    if ($conn->query($sql)) {
        return ['success' => true, 'message' => 'User deleted successfully'];
    } else {
        return ['success' => false, 'message' => 'Error deleting user: ' . $conn->error];
    }
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $response = deleteUser($conn, $userId);
    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'User ID is required for deletion']);
}
?>
