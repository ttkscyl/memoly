<?php

require_once "connection.php";
require_once "navbar.php";
session_start();  // Start session to access UserID

// Ensure only logged-in users can create sets
if (!isset($_SESSION['UserID'])) {
    echo "You must be logged in.";
    exit();
}

// Retrieve form data
$setname = $_POST['setname'];
$folderid = $_POST['folderid'];

// Retrieve UserID from session instead of form input
$userid = $_SESSION['UserID'];

try {

    // Insert the new set into the database (I used prepare statements to stop SQL injection)
    $stmt = $conn->prepare(
        "INSERT INTO Sets (SetName, FolderID, UserID) VALUES (?, ?, ?)"
    );

    $stmt->execute([$setname, $folderid, $userid]);

    echo "Set created successfully.";

} catch (PDOException $e) {

    // Display error during development for debugging
    echo "Error: " . $e->getMessage();
}

?>