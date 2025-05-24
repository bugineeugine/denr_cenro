<?php 
include('../../config.php');
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Permit ID is required']);
    exit;
}

$permitId = $conn->real_escape_string($_GET['id']);

// Check if permit exists
$checkSql = "SELECT COUNT(*) as cnt FROM permits WHERE id = '$permitId'";
$result = $conn->query($checkSql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Error checking permit: ' . $conn->error]);
    exit;
}

$row = $result->fetch_assoc();
if ($row['cnt'] == 0) {
    echo json_encode(['success' => false, 'message' => 'Permit not found']);
    exit;
}

// Permit exists, delete it
$deleteSql = "DELETE FROM permits WHERE id = '$permitId'";
if ($conn->query($deleteSql)) {
    echo json_encode(['success' => true, 'message' => 'Permit deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting permit: ' . $conn->error]);
}
?>
