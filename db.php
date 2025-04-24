/**
 * Database Connection Configuration
 * 
 * This file establishes the connection to the MySQL database using the following credentials:
 * - Host: localhost
 * - Username: root
 * - Password: (empty)
 * - Database: student_db
 */

<?php
// Create a new MySQL connection
$conn = new mysqli('localhost', 'root', '', 'student_db');

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>