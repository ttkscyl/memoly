<!DOCTYPE html>
<html>

<head>
    <title>Memoly | Add Folder</title>
</head>

<body>

    <h2>Create Folder</h2>

    <!-- Display error message if redirected with error -->
    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>Error creating folder.</p>";
    }
    ?>

    <!-- 
        Form for the user to enter details to create a new folder.
        Data is sent to addfolders.php using POST.
    -->
    <form action="addfolders.php" method="POST">

        <!-- Folder name input -->
        <input type="text" name="folder_name" placeholder="New Folder Name" required>
        <br>

        <!-- Folder description input -->
        <input type="text" name="folder_description" placeholder="Folder Description" required>
        <br>

        <!-- Submit button -->
        <button type="submit">Create Folder</button>
    </form>

</body>
</html>