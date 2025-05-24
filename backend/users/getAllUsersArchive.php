<?php 
    include('../../config.php');
    $sql = "SELECT * FROM users WHERE is_archived = 1";
    $result = $conn->query($sql);
    $users = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }


  echo json_encode(['data' => $users]);


?>