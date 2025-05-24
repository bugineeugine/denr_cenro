<?php 
include('../config.php');
require_once(__DIR__ . '/../helpers/generateUUID.php');


// Get all users
function getAllUsers($conn) {
    $sql = "SELECT * FROM users WHERE is_archived = 0";
    $result = $conn->query($sql);
    $users = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Check if email exists
function emailExists($conn, $email) {
    $email = $conn->real_escape_string($email);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    return $result && $result->num_rows > 0;
}

// Check if username exists
function usernameExists($conn, $username) {
    $username = $conn->real_escape_string($username);
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    return $result && $result->num_rows > 0;
}

// Insert a new user
function insertUser($conn, $data) {

    // Check if email already exists
    if (emailExists($conn, $data['email'])) {
        return ['success' => false, 'message' => 'Email already exists'];
    }

    // Check if username already exists
    if (usernameExists($conn, $data['username'])) {
        return ['success' => false, 'message' => 'Username already exists'];
    }


    $uuid = generateUUID();
    $full_name = $conn->real_escape_string($data['full_name']);
    $username = $conn->real_escape_string($data['username']);
    $email = $conn->real_escape_string($data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($data['role']);

    $sql = "INSERT INTO users (id, full_name, username, email, password, role) 
            VALUES ('$uuid', '$full_name', '$username', '$email', '$password', '$role')";

    if ($conn->query($sql)) {
        return ['success' => true, 'message' => 'User added successfully', 'id' => $uuid];
    } else {
        return ['success' => false, 'message' => 'Error: ' . $conn->error];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $response = insertUser($conn, $input);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $users = getAllUsers($conn);
    header('Content-Type: application/json');
    echo json_encode(['data' => $users]);
    exit;
}
?>
