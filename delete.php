<!-- /**
 * Delete Student Handler
 * 
 * This script handles the deletion of a student record.
 * It includes security measures to prevent SQL injection
 * and provides feedback through flash messages.
 */ -->

<?php
include 'db.php';      // Database connection
session_start();       // Start session for flash messages

// Get and sanitize student ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Student deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting student.";
    }
} else {
    $_SESSION['message'] = "Invalid student ID.";
}

// Redirect back to the main page
header("Location: index.php");
exit();
