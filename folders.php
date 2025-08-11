<!DOCTYPE html>

    <head>
        <title>Add Folders</title>
    </head>

    <body>
<!-- form for the user to enter details to create a new folder -->
        <form action="addfolders.php" method="POST">
            <input type="text" name="folder_name" placeholder="New Folder Name" required> <!-- folder name -->
            <br>
            <input type="text" name="folder_description" placeholder="Folder Description" required> <!-- description -->
            <br>
            <button type="submit" value="confirm">Create Folder</button> <!-- submit button -->
        </form>
    </body>
</html>