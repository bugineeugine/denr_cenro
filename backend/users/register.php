<?php


    include('../../config.php');
    require_once('../../helpers/generateUUID.php');
// /../helpers/generateUUID.php


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


function insertUser($conn, $data) {
    header('Content-Type: application/json');
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }

    // Check if email already exists
    if (emailExists($conn, $data['email'])) {
        return ['success' => false, 'message' => 'Email already exists'];
    }

    // Check if username already exists
    if (usernameExists($conn, $data['username'])) {
        return ['success' => false, 'message' => 'Username already exists'];
    }

        // Generate UUID for the new user
        $uuid = generateUUID();
        $full_name = $conn->real_escape_string($data['full_name']);
        $username = $conn->real_escape_string($data['username']);
        $email = $conn->real_escape_string($data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);


        $sql = "INSERT INTO users (id, full_name, username, email, password, role,is_archived) 
                VALUES ('$uuid', '$full_name', '$username', '$email', '$password', 'applicant',0)";

        if ($conn->query($sql)) {
            return ['success' => true, 'message' => 'Register successfully', 'id' => $uuid];
        } else {
            return ['success' => false, 'message' => 'Error: ' . $conn->error];
        }
    }

     $input = json_decode(file_get_contents('php://input'), true);

    $required_fields = ['full_name', 'username', 'email', 'password', ];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            echo json_encode(['success' => false, 'message' => ucfirst($field) . ' is required']);
            exit;
        }
    }

    $response = insertUser($conn, $input);
    echo json_encode($response);

?>