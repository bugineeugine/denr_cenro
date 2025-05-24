<?php 
include('../../config.php');
header('Content-Type: application/json');

// Get raw JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($input['holder_id']) || !isset($input['issued_date'])) {
  echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
  exit;
}

$holderId = $input['holder_id'];
$issuedDate = $input['issued_date'];
$permitType = $input['permit_type'];
$status = 'pending';

try {

  $result = $conn->query("SELECT id FROM permits ORDER BY id DESC LIMIT 1");
  $lastId = 0;

  if ($result && $row = $result->fetch_assoc()) {
    $lastPermitId = $row['id'];

    $lastId = (int)substr($lastPermitId, 4);
  }


  $newId = $lastId + 1;
  $permitId = 'PRM-' . str_pad($newId, 6, '0', STR_PAD_LEFT);

  // Insert into database
  $stmt = $conn->prepare("INSERT INTO permits (id, holder_name, issued_date, status,permit_type) VALUES (?, ?, ?, ?,?)");
  $stmt->bind_param("sssss", $permitId, $holderId, $issuedDate, $status,$permitType);

  if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Permit saved successfully.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Failed to save permit.']);
  }

  $stmt->close();
} catch (Exception $e) {
  echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
