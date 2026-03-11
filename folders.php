<?php require_once "navbar.php"; ?>

<?php
session_start();

// Only allow access if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Folder</title>
</head>
<body>

    <h2>Create a New Folder</h2>

    <!-- The form uses POST because folder details should not appear in the URL.-->
    <!-- Data is sent to addfolders.php for processing.-->
    <form action="addfolders.php" method="POST">

        <label>Folder Name:</label><br>
        <input type="text" name="foldername" required><br><br>

        <input type="submit" value="Create Folder">

    </form>

</body>
</html>