<?php
require_once "connection.php";
require_once "navbar.php"; 
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: login.html");
    exit();
}

$userid = $_SESSION['UserID'];

// Retrieve folders belonging to the logged-in user
$stmt = $conn->prepare("SELECT * FROM Folders WHERE UserID = ?");
$stmt->execute([$userid]);
$folders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Set</title>
</head>
<body>

<h2>Create a New Set</h2>

<form action="addsets.php" method="POST">

    <label>Set Name:</label><br>
    <input type="text" name="setname" required><br><br>

    <label>Select Folder:</label><br>
    <select name="folderid" required>

        <?php foreach ($folders as $folder) { ?>
            <option value="<?php echo $folder['FolderID']; ?>">
            <?php echo $folder['FolderName']; ?>
            </option>
        <?php } ?>

    </select><br><br>

    <input type="submit" value="Create Set">

</form>

</body>
</html>