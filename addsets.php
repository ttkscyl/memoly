<?php
session_start();
try {
    include_once("connection.php");
    array_map("htmlspecialchars", $_POST);

    // Insert set detail into table
    $stmt = $conn->prepare("
        INSERT INTO TblSets (SetName, SetDescription, Status) 
        VALUES (:SetName, :SetDescription, :Status)
    ");
    $stmt->bindParam(':SetName', $_POST['SetName']);
    $stmt->bindParam(':SetDescription', $_POST['SetDescription']);
    $stmt->bindParam(':Status', $_POST['status']);
    $stmt->execute();

    // Get last inserted SetID
    $currentSet = $conn->lastInsertId();

    // OPTIONAL: link SetID to a folder if you add folders later
    /*
    $stmt3 = $conn->prepare("
        INSERT INTO TblFolderContent (FolderID, SetID) 
        VALUES (:FolderID, :SetID)
    ");
    $stmt3->bindParam(':FolderID', $_POST['folders']);
    $stmt3->bindParam(':SetID', $currentSet);
    $stmt3->execute();
    */

    // Redirect back to sets page
    header('Location: sets.php?success=1');
    exit();

} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}

$conn = null;
?>