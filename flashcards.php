<?php
require_once "connection.php";
require_once "navbar.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.html");
    exit();
}

$userid = $_SESSION['UserID'];

// Retrieve sets belonging to this user
$stmt = $conn->prepare("SELECT * FROM Sets WHERE UserID = ?");
$stmt->execute([$userid]);
$sets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Flashcard</title>
</head>
<body>

<h2>Create a Flashcard</h2>

<form action="addflashcards.php" method="POST">

    <label>Select Set:</label><br>
    <select name="setid" required>
        <?php foreach ($sets as $set) { ?>
            <option value="<?php echo $set['SetID']; ?>">
                <?php echo $set['SetName']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Term:</label><br>
    <input type="text" name="term" required><br><br>

    <label>Definition:</label><br>
    <textarea name="definition" required></textarea><br><br>

    <input type="submit" value="Create Flashcard">

</form>

</body>
</html>