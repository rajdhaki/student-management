/**
 * Flash Message Handler
 * 
 * This file manages the display of flash messages across the application.
 * It uses PHP sessions to store temporary messages that need to be displayed
 * to the user after redirects (e.g., success messages, error notifications).
 */

<?php
// Start the session if not already started
session_start();

// Check if there's a message in the session
if (isset($_SESSION['message'])) {
    // Display the message in an alert div
    echo "<div class='alert'>{$_SESSION['message']}</div>";
    // Remove the message from session to prevent displaying it again
    unset($_SESSION['message']);
}
?>