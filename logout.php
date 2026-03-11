<?php
session_start();  // Start the session so it can be modified

// Remove all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect user
header("Location: index.html");
exit();
?>