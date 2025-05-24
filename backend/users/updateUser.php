<?php

    include('../../config.php');
  header('Content-Type: application/json');
function updateUser($conn, $data) {
    $id = $conn->real_escape_string($data['id']);
    $full_name = $conn->real_escape_string($data['full_name']);
    $username = $conn->real_escape_string($data['username']);
    $email = $conn->real_escape_string($data['email']);
    $role = $conn->real_escape_string($data['role']);
    $password = !empty($data['password']) ? password_hash($conn->real_escape_string($data['password']), PASSWORD_DEFAULT) : null;

    // Validate email format
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }

    // Check if email already exists for a *different* user
    $emailCheckSql = "SELECT id FROM users WHERE email = '$email' AND id != '$id' LIMIT 1";
    $emailCheckResult = $conn->query($emailCheckSql);
    if ($emailCheckResult && $emailCheckResult->num_rows > 0) {
        return ['success' => false, 'message' => 'Email already exists for another user'];
    }

     // Check if username already exists for a *different* user
    $usernameCheckSql = "SELECT id FROM users WHERE username = '$username' AND id != '$id' LIMIT 1";
    $usernameCheckResult = $conn->query($usernameCheckSql);
     if ($usernameCheckResult && $usernameCheckResult->num_rows > 0) {
        return ['success' => false, 'message' => 'Username already exists for another user'];
    }

    $sql = "UPDATE users SET 
            full_name = '$full_name',
            username = '$username',
            email = '$email',
            role = '$role'";
            
    if ($password) {
        $sql .= ", password = '$password'";
    }

    $sql .= " WHERE id = '$id'";

    if ($conn->query($sql)) {
        return ['success' => true, 'message' => 'User updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Error: ' . $conn->error];
    }
}


   $input = json_decode(file_get_contents('php://input'), true);

    // Validate required fields for PUT
     $required_fields = ['id', 'full_name', 'username', 'email', 'role'];
    foreach ($required_fields as $field) {
        if (!isset($input[$field]) || empty($input[$field]) && $field !== 'password') {
            echo json_encode(['success' => false, 'message' => ucfirst($field) . ' is required']);
            exit;
        }
    }

    $response = updateUser($conn, $input);
    echo json_encode($response);





?>