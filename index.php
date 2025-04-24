/**
 * Student Management System - Main Page
 * 
 * This is the primary interface of the Student Management System.
 * Features:
 * - Display list of all students
 * - Search functionality for students by name or course
 * - Links to add, edit, and delete students
 * - XSS prevention through proper data escaping
 */

<?php
// Include necessary dependencies
include 'db.php';        // Database connection
include 'messages.php';  // Flash messages handler

// Initialize search functionality
$search = '';
if (isset($_GET['search'])) {
    // Sanitize the search input to prevent SQL injection
    $search = $conn->real_escape_string($_GET['search']);
    // Query to search in both name and course fields
    $result = $conn->query("SELECT * FROM students WHERE name LIKE '%$search%' OR course LIKE '%$search%'");
} else {
    // If no search term, fetch all students
    $result = $conn->query("SELECT * FROM students");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <!-- Include required stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Student Management System</h1>
    
    <!-- Search Form Section -->
    <form method="GET" style="margin-bottom: 20px;">
        <!-- Search input with XSS prevention on value attribute -->
        <input type="text" 
               name="search" 
               placeholder="Search by name or course" 
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
        <!-- Reset search link -->
        <a href="index.php">Reset</a>
    </form>
    
    <!-- Add New Student Button -->
    <a href="add.php">+ Add New Student</a>
    
    <!-- Students Data Table -->
    <table>
        <!-- Table Headers -->
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
        
        <!-- Loop through each student record -->
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <!-- Display student information with XSS prevention -->
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td>
                <!-- Action buttons -->
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                <!-- Delete with confirmation dialog -->
                <a href="delete.php?id=<?= $row['id'] ?>" 
                   onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
