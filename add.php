<!-- /**
 * Add New Student Page
 * 
 * This page provides a form to add a new student to the database.
 * It includes client-side validation for the form fields and
 * server-side processing of the submitted data.
 */ -->

<?php
include 'db.php';      // Database connection
session_start();       // Start session for flash messages

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare and execute the INSERT statement with parameterized query
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, course) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['course']);
    $stmt->execute();
    
    // Set success message and redirect
    $_SESSION['message'] = "Student added successfully!";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Add New Student</h1>
    <!-- Student Registration Form -->
    <form method="POST" onsubmit="return validateForm()">
        <input name="name" placeholder="Name" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="phone" placeholder="Phone" required>
        <input name="course" placeholder="Course" required>
        <button type="submit">Add Student</button>
    </form>
</div>
</body>
</html>

<script>
/**
 * Validates the form input before submission
 * Checks for:
 * - Non-empty fields
 * - Valid 10-digit phone number
 * 
 * @returns {boolean} Whether the form is valid
 */
function validateForm() {
    // Get form field values
    const name = document.forms[0]["name"].value.trim();
    const email = document.forms[0]["email"].value.trim();
    const phone = document.forms[0]["phone"].value.trim();
    const course = document.forms[0]["course"].value.trim();
    
    // Check for empty fields
    if (!name || !email || !phone || !course) {
        alert("All fields are required.");
        return false;
    }
    
    // Validate phone number format
    if (!/^[0-9]{10}$/.test(phone)) {
        alert("Enter a valid 10-digit phone number.");
        return false;
    }
    
    return true;
}
</script>
