<?php
/*
    addfolders.php
    Inserts a new folder into TblFolders for the currently logged-in user.
*/

// Start session to access logged-in user
session_start();

/*
    Ensure user is logged in before allowing folder creation.
*/
if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

try {
    // Connect to database
    include_once('connection.php');

    /*
        Server-side validation to ensure required fields are not empty.
    */
    if (empty($_POST['folder_name']) || empty($_POST['folder_description'])) {
        header("Location: folders.php?error=emptyfields");
        exit();
    }

    /*
        Prepare SQL statement to insert folder.
        The folder is linked to the logged-in user via user_id.
    */
    $stmt = $conn->prepare(
        "INSERT INTO TblFolders (user_id, folder_name, folder_description)
         VALUES (:user_id, :folder_name, :folder_description)"
    );

    // Bind values
    $stmt->bindParam(':user_id', $_SESSION['CurrentUser']);
    $stmt->bindParam(':folder_name', $_POST['folder_name']);
    $stmt->bindParam(':folder_description', $_POST['folder_description']);

    // Execute insert
    $stmt->execute();

    // Redirect back to folders page after success
    header("Location: folders.php");
    exit();

} catch (PDOException $e) {
    // Redirect back with error message
    header("Location: folders.php?error=1");
    exit();
}

// Close database connection
$conn = null;
?>