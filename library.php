<?php
require_once "connection.php";
require_once "navbar.php";
session_start();  // Start session

// Ensure that only logged-in users can access the library page
if (!isset($_SESSION['UserID'])) {
    header("Location: login.html");
    exit();
}

$userid = $_SESSION['UserID'];  // Retrieve current user's ID

// Retrieve folders that belong to the logged-in user
$stmt = $conn->prepare("SELECT * FROM Folders WHERE UserID = ?");
$stmt->execute([$userid]);
$folders = $stmt->fetchAll();

$selectedFolder = null;
$sets = [];

if (isset($_GET['folderid'])) {

    $selectedFolder = $_GET['folderid'];

    // Retrieve sets in the selected folder
    $stmt = $conn->prepare("SELECT * FROM Sets WHERE FolderID = ?");
    $stmt->execute([$selectedFolder]);
    $sets = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Library</title>

<style>

/* Center the whole page content */
body {
    text-align: center;
    font-family: Arial, sans-serif;
}

/* Container for folders */
.folder-container {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 30px;
}

/* Folder box style */
.folder {
    padding: 10px 20px;
    border: 2px solid black;
    text-decoration: none;
    color: black;
}

/* Container for sets */
.set-container {
    margin-top: 20px;
}

/* Set box style */
.set {
    display: block;
    padding: 8px 15px;
    border: 2px solid black;
    margin: 10px auto;
    width: 120px;
    text-align: center;
    text-decoration: none;
    color: black;
}

/* Folder box style */
.folder {
    padding: 10px 20px;
    border: 2px solid black;
    text-decoration: none;
    color: black;
}

/* Highlight the selected folder */
.folder.selected {
    background-color: #cfe2ff;
    border: 3px solid #2b6cb0;
}

</style>

</head>

<body>

<h2>Your Library</h2>

<!-- Display folders in a centered row -->
<div class="folder-container">

<?php foreach ($folders as $folder) { 

    // Check if this folder is the one currently selected
    $class = "folder";
    if ($selectedFolder == $folder['FolderID']) {
        $class .= " selected";
    }

?>

<a class="<?php echo $class; ?>"
   href="library.php?folderid=<?php echo $folder['FolderID']; ?>">

   <?php echo $folder['FolderName']; ?>

</a>

<?php } ?>

</div>
<br>


<!-- Display sets if a folder is selected -->

<?php if ($selectedFolder) { ?>

<h3>Sets in this folder</h3>

<?php foreach ($sets as $set) { ?>

<div style="display:flex; justify-content:center; align-items:center; gap:20px; margin:10px;">

    <!-- Set name -->
    <div style="border:2px solid black; padding:10px; width:150px; text-align:center;">
        <?php echo $set['SetName']; ?>
    </div>

    <!-- Learn button -->
    <a href="learn.php?setid=<?php echo $set['SetID']; ?>"
       style="border:2px solid black; padding:10px; width:100px; text-align:center; text-decoration:none;">
       Learn
    </a>

    <!-- Test button -->
    <a href="test.php?setid=<?php echo $set['SetID']; ?>"
       style="border:2px solid black; padding:10px; width:100px; text-align:center; text-decoration:none;">
       Test
    </a>

</div>

<?php } ?>

<?php } ?>

</body>
</html>