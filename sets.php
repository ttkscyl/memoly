<?php
// Start session to identify logged-in user
session_start();

// Redirect if not logged in
if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

include_once("connection.php");

// Retrieve folders belonging to the logged-in user
$stmt = $conn->prepare(
    "SELECT folder_id, folder_name 
     FROM TblFolders 
     WHERE user_id = :user_id"
);
$stmt->bindParam(":user_id", $_SESSION['CurrentUser']);
$stmt->execute();
$folders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Memoly | Create Set</title>
</head>

<body>

<h2>Create a New Set</h2>

<?php
if (isset($_GET['error'])) {
    echo "<p style='color:red;'>Error creating set.</p>";
}
?>

<!-- Form to create a new flashcard set -->
<form action="addsets.php" method="POST">

    <!-- Set title -->
    <input type="text" name="title" placeholder="Set Title" required>
    <br>

    <!-- Set description -->
    <input type="text" name="description" placeholder="Set Description" required>
    <br>

    <!-- Folder selection dropdown -->
    <label for="folder_id">Select Folder:</label><br>
    <select name="folder_id" required>
        <option value="">-- Choose Folder --</option>

        <?php
        // Populate dropdown with user's folders
        foreach ($folders as $folder) {
            echo "<option value='{$folder['folder_id']}'>
                    {$folder['folder_name']}
                  </option>";
        }
        ?>
    </select>
    <br><br>

    <!-- Public / Private option -->
    <label>
        <input type="radio" name="is_public" value="1"> Public
    </label>
    <label>
        <input type="radio" name="is_public" value="0" checked> Private
    </label>
    <br><br>

    <button type="submit">Create Set</button>
</form>

</body>
</html>

<?php
$conn = null;
?>