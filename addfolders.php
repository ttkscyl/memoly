<?php

header('location: folders.php');

try {
    include_once('connection.php');
    array_map("htmlspecialchars", $_POST);

    // add folder information into database table
    $stmt = $conn->prepare("INSERT INTO TblFolders (folder_id, folder_name, folder_description) VALUES (NULL, :folder_name, :folder_description)");

    $stmt->bindParam(':folder_name', $_POST['folder_name']);
    $stmt->bindParam(':folder_description', $_POST['folder_description']);

    $stmt->execute();
} catch (PDOException $e) {
    // if there is an error, redirect to folders.php with error message
    header("Location: folders.php?error=" . urlencode($e->getMessage()));
    exit();
}
$conn = null;