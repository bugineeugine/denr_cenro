<?php 
include('../../config.php');

$sql = "
    SELECT 
        applications.*, 
        users.id AS user_id,
        users.full_name, 
        users.email, 
        users.username
    FROM applications
    LEFT JOIN users ON applications.application_id = users.id
";

$result = $conn->query($sql);

$applications = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = [
            'id' => $row['id'],
            'status' => $row['status'],
            'application_type' => $row['application_type'],
            'reason' => $row['reason'],
            'date_submitted' => date("F j, Y g:i A", strtotime($row['date_submitted'])),
            'created_at' => $row['created_at'],
             'updated_at' => $row['updated_at'],
            'application' => [
                'id' => $row['user_id'],
                'full_name' => $row['full_name'],
                'email' => $row['email'],
                'username' => $row['username']
            ]
        ];
    }
}

echo json_encode(['data' => $applications]);
?>
