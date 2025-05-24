<?php 
include('../../config.php');
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$id = isset($input['permitId']) ? $input['permitId'] : null;
$status = isset($input['status']) ? $input['status'] : null;

if (!$id || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing permit ID or status']);
    exit;
}

$id = $conn->real_escape_string($id);
$status = $conn->real_escape_string($status);

// Check if permit exists
$checkSql = "SELECT id FROM permits WHERE id = '$id' LIMIT 1";
$result = $conn->query($checkSql);

if (!$result || $result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Permit not found']);
    exit;
}

// Update permit status
$sql = "UPDATE permits SET status = '$status' WHERE id = '$id'";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Permit status updated to ' . $status]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}
?>
