<!-- /**
 * Edit Student Page
 * 
 * This page allows editing of existing student information.
 * It pre-fills the form with current student data and includes
 * both client-side validation and server-side processing.
 */ -->

<?php
include 'db.php';      // Database connection
session_start();       // Start session for flash messages

// Get student ID from URL and fetch student data
$id = $_GET['id'];
$student = $conn->query("SELECT * FROM students WHERE id = $id")->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare and execute UPDATE statement with parameterized query
    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, course=? WHERE id=?");
    $stmt->bind_param("ssssi", $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['course'], $id);
    $stmt->execute();
    
    // Set success message and redirect
    $_SESSION['message'] = "Student updated successfully!";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Student</h1>
    <!-- Student Edit Form with Pre-filled Values -->
    <form method="POST" onsubmit="return validateForm()">
        <input name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        <input name="email" value="<?= htmlspecialchars($student['email']) ?>" type="email" required>
        <input name="phone" value="<?= htmlspecialchars($student['phone']) ?>" required>
        <input name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
        <button type="submit">Update Student</button>
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
