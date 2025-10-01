<?php
// Add sets - add the posted value into the corresponding table
session_start();

try {
    include_once('connection.php');

    // Sanitize input
    $_POST = array_map("htmlspecialchars", $_POST);

    // Debug (remove in production)
    // print_r($_POST);

    // Determine role (public/private)
    switch ($_POST["status"]) {
        case "Private":
            $role = 0;
            break;
        case "Public":
            $role = 1;
            break;
        default:
            $role = 0;
    }

    // Insert into TblSets
    $stmt = $conn->prepare("
        INSERT INTO TblSets (SetID, SetName, UserID, `Public`, SetDescription) 
        VALUES (NULL, :SetName, :UserID, :status, :SetDescription)
    ");
    $stmt->bindParam(':SetName', $_POST["SetName"]);
    $stmt->bindParam(':UserID', $_SESSION['CurrentUser']);
    $stmt->bindParam(':status', $role);
    $stmt->bindParam(':SetDescription', $_POST["SetDescription"]);
    $stmt->execute();

    // Get last inserted SetID
    $currentSet = $conn->lastInsertId();

    // Link SetID with Folder if provided
    if (!empty($_POST["Folders"])) {
        $stmt3 = $conn->prepare("
            INSERT INTO TblFolderContent (FolderID, SetID) 
            VALUES (:FolderID, :SetID)
        ");
        $stmt3->bindParam(':FolderID', $_POST["Folders"]);
        $stmt3->bindParam(':SetID', $currentSet);
        $stmt3->execute();
    }

    // Redirect after success
    header('Location: sets.php');
    exit;

} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}

$conn = null;
?>