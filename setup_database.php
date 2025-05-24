<?php
include('config.php');

// Read the SQL file
$sql = file_get_contents('create_users_table.sql');

// Execute the SQL
if ($conn->multi_query($sql)) {
    echo "Users table created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?> 