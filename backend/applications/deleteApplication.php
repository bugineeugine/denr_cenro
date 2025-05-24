<?php 
include('../../config.php');
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Application ID is required']);
    exit;
}

$applicationId = $conn->real_escape_string($_GET['id']);

// Check if application exists
$checkSql = "SELECT COUNT(*) as cnt FROM applications WHERE id = '$applicationId'";
$result = $conn->query($checkSql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Error checking application: ' . $conn->error]);
    exit;
}

$row = $result->fetch_assoc();
if ($row['cnt'] == 0) {
    echo json_encode(['success' => false, 'message' => 'Application not found']);
    exit;
}

// application exists, delete it
$deleteSql = "DELETE FROM applications WHERE id = '$applicationId'";
if ($conn->query($deleteSql)) {
    echo json_encode(['success' => true, 'message' => 'Application deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting application: ' . $conn->error]);
}
?>
