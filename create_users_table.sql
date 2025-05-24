-- Drop the existing users table if it exists
DROP TABLE IF EXISTS users;

-- Create users table with UUID
CREATE TABLE users (
    id VARCHAR(36) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'verifier') NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_archived TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY username (username),
    UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 