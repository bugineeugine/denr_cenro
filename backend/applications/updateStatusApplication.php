<?php 
include('../../config.php');
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$id = isset($input['applicationId']) ? $input['applicationId'] : null;
$status = isset($input['status']) ? $input['status'] : null;

if (!$id || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing application ID or status']);
    exit;
}

$id = $conn->real_escape_string($id);
$status = $conn->real_escape_string($status);

// Check if application exists
$checkSql = "SELECT id FROM applications WHERE id = '$id' LIMIT 1";
$result = $conn->query($checkSql);

if (!$result || $result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Application not found']);
    exit;
}

// Update application status
$sql = "UPDATE applications SET status = '$status' WHERE id = '$id'";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Application status updated to ' . $status]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}
?>
