<?php
/*
    addsets.php
    Inserts a new set into TblDecks and links it to a folder.
*/

session_start();

// Ensure user is logged in
if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

try {
    include_once("connection.php");

    /*
        Server-side validation
    */
    if (
        empty($_POST['title']) ||
        empty($_POST['description']) ||
        empty($_POST['folder_id'])
    ) {
        header("Location: sets.php?error=emptyfields");
        exit();
    }

    // Set public/private value
    $is_public = isset($_POST['is_public']) ? $_POST['is_public'] : 0;

    /*
        Insert set into TblDecks, linked to:
        - logged-in user
        - selected folder
    */
    $stmt = $conn->prepare(
        "INSERT INTO TblDecks (user_id, folder_id, title, description, is_public)
         VALUES (:user_id, :folder_id, :title, :description, :is_public)"
    );

    $stmt->bindParam(":user_id", $_SESSION['CurrentUser']);
    $stmt->bindParam(":folder_id", $_POST['folder_id']);
    $stmt->bindParam(":title", $_POST['title']);
    $stmt->bindParam(":description", $_POST['description']);
    $stmt->bindParam(":is_public", $is_public, PDO::PARAM_INT);

    $stmt->execute();

    // Redirect after successful creation
    header("Location: sets.php");
    exit();

} catch (PDOException $e) {
    header("Location: sets.php?error=1");
    exit();
}

$conn = null;
?>