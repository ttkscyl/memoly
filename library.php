<?php include_once("navbar.php"); ?>

<?php
// library.php
// Displays all folders and the sets (decks) within them for the logged-in user

session_start();

// Redirect user to login if not logged in
if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

include_once("connection.php");

/*
    Retrieve all folders belonging to the logged-in user.
*/
$foldersStmt = $conn->prepare(
    "SELECT folder_id, folder_name, folder_description
     FROM TblFolders
     WHERE user_id = :user_id
     ORDER BY folder_name ASC"
);
$foldersStmt->bindParam(":user_id", $_SESSION['CurrentUser'], PDO::PARAM_INT);
$foldersStmt->execute();
$folders = $foldersStmt->fetchAll(PDO::FETCH_ASSOC);

/*
    Check if a folder has been selected using a GET parameter.
*/
$selectedFolderId = (isset($_GET['folder_id']) && ctype_digit($_GET['folder_id']))
    ? (int)$_GET['folder_id']
    : null;

$selectedFolder = null;
$decks = [];

if ($selectedFolderId !== null) {

    /*
        Security check:
        Ensure the selected folder belongs to the logged-in user.
    */
    $folderCheck = $conn->prepare(
        "SELECT folder_id, folder_name, folder_description
         FROM TblFolders
         WHERE folder_id = :folder_id AND user_id = :user_id"
    );
    $folderCheck->bindParam(":folder_id", $selectedFolderId, PDO::PARAM_INT);
    $folderCheck->bindParam(":user_id", $_SESSION['CurrentUser'], PDO::PARAM_INT);
    $folderCheck->execute();
    $selectedFolder = $folderCheck->fetch(PDO::FETCH_ASSOC);

    /*
        If the folder is valid, retrieve all decks in that folder.
    */
    if ($selectedFolder) {
        $decksStmt = $conn->prepare(
            "SELECT deck_id, title, description, is_public, created_at
             FROM TblDecks
             WHERE folder_id = :folder_id AND user_id = :user_id
             ORDER BY created_at DESC"
        );
        $decksStmt->bindParam(":folder_id", $selectedFolderId, PDO::PARAM_INT);
        $decksStmt->bindParam(":user_id", $_SESSION['CurrentUser'], PDO::PARAM_INT);
        $decksStmt->execute();
        $decks = $decksStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Close database connection
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Memoly | Library</title>
</head>

<body>

<h1>My Library</h1>

<!-- Two-column layout -->
<div style="display:flex; gap:40px;">

    <!-- LEFT COLUMN: Folders -->
    <div style="width:30%;">
        <h3>Folders</h3>

        <?php if (count($folders) === 0): ?>
            <p>No folders created yet.</p>
            <a href="folders_create.php">Create a folder</a>
        <?php else: ?>
            <ul>
                <?php foreach ($folders as $folder): ?>
                    <li>
                        <a href="library.php?folder_id=<?php echo (int)$folder['folder_id']; ?>">
                            <?php echo htmlspecialchars($folder['folder_name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- RIGHT COLUMN: Decks -->
    <div style="width:70%;">

        <?php if ($selectedFolder): ?>

            <h3>
                Sets in "<?php echo htmlspecialchars($selectedFolder['folder_name']); ?>"
            </h3>

            <?php if (!empty($selectedFolder['folder_description'])): ?>
                <p><?php echo htmlspecialchars($selectedFolder['folder_description']); ?></p>
            <?php endif; ?>

            <?php if (count($decks) === 0): ?>
                <p>No sets in this folder.</p>
                <a href="sets.php">Create a set</a>
            <?php else: ?>
                <table border="1" cellpadding="8" cellspacing="0">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Visibility</th>
                        <th>Actions</th>
                    </tr>

                    <?php foreach ($decks as $deck): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($deck['title']); ?></td>
                            <td><?php echo htmlspecialchars($deck['description']); ?></td>
                            <td>
                                <?php echo ((int)$deck['is_public'] === 1) ? "Public" : "Private"; ?>
                            </td>
                            <td>
                                <!-- Learn mode -->
                                <a href="learn.php?deck_id=<?php echo (int)$deck['deck_id']; ?>">
                                    Learn
                                </a>
                                &nbsp;|&nbsp;

                                <!-- Test mode -->
                                <a href="test.php?deck_id=<?php echo (int)$deck['deck_id']; ?>">
                                    Test
                                </a>
                                &nbsp;|&nbsp;

                                <!-- Add flashcards -->
                                <a href="cards.php">
                                    Add Cards
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>

        <?php else: ?>
            <p>Select a folder to view its sets.</p>
        <?php endif; ?>

    </div>
</div>

</body>
</html>