<?php
// Start the session so the session variable can be accessed
session_start();

// Check if a user is currently logged in
if (isset($_SESSION['CurrentUser'])) {
    // Remove the session variable that stores the logged-in user
    unset($_SESSION['CurrentUser']);
}

// Redirect the user back to the login page after logout
header('Location: login.php');
exit();
?>