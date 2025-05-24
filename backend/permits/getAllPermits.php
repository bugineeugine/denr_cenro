<?php 
include('../../config.php');

$sql = "
    SELECT 
        permits.*, 
        users.id AS user_id,
        users.full_name, 
        users.email, 
        users.username
    FROM permits
    LEFT JOIN users ON permits.holder_name = users.id
";

$result = $conn->query($sql);

$permits = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $permits[] = [
            'id' => $row['id'],
            'status' => $row['status'],
             'permit_type' => $row['permit_type'],
                'issued_date' => date("F j, Y g:i A", strtotime($row['issued_date'])),

            'created_at' => $row['created_at'],
            'holder' => [
                'id' => $row['user_id'],
                'full_name' => $row['full_name'],
                'email' => $row['email'],
                'username' => $row['username']
            ]
        ];
    }
}

echo json_encode(['data' => $permits]);
?>
