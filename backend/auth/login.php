<?php 
include('../../config.php');
header('Content-Type: application/json');


$data = json_decode(file_get_contents("php://input"), true);

// Validate fields
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
    exit;
}

$username = $conn->real_escape_string($data['username']);
$password = $data['password'];

// Check if user exists
$sql = "SELECT id, username, is_archived,password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    exit;
}

$user = $result->fetch_assoc();

if($user['is_archived'] == 1){
    echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    exit;
}

// Verify password
if (!password_verify($password, $user['password'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    exit;
}


echo json_encode([
    'success' => true,
    'message' => 'Login successful.',
    'user' => [
        'id' => $user['id'],
        'username' => $user['username']
    ]
]);

$stmt->close();
?>
