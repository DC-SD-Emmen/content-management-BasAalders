<?php
// Start the session if it isn't already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if a session exists before destroying it
if (isset($_SESSION)) {
    unset($_SESSION['username']);
    session_unset();     // Free all session variables
    session_destroy();   // Destroy the session
}
// Redirect the user to the homepage or another page after logout
header("Location: index.php");
exit();
?>