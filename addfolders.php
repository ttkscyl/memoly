<?php

require_once "connection.php";
require_once "navbar.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['UserID'])) {
    echo "You must be logged in.";
    exit();
}

// Get folder name from form
$foldername = $_POST['foldername'];

// Get logged-in user's ID from session
$userid = $_SESSION['UserID'];

try {

    // Insert new folder linked to the current user
    $stmt = $conn->prepare("INSERT INTO Folders (FolderName, UserID) VALUES (?, ?)");
    $stmt->execute([$foldername, $userid]);

    echo "Folder created successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>