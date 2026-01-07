<?php
// test.php
// Simple testing mode for a flashcard deck

session_start();
if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

include_once("connection.php");

// Validate deck_id
if (!isset($_GET['deck_id']) || !ctype_digit($_GET['deck_id'])) {
    header("Location: library.php");
    exit();
}

$deck_id = (int)$_GET['deck_id'];

/*
    Ensure the deck belongs to the logged-in user
*/
$check = $conn->prepare(
    "SELECT title FROM TblDecks
     WHERE deck_id = :deck_id AND user_id = :user_id"
);
$check->bindParam(":deck_id", $deck_id);
$check->bindParam(":user_id", $_SESSION['CurrentUser']);
$check->execute();
$deck = $check->fetch(PDO::FETCH_ASSOC);

if (!$deck) {
    header("Location: library.php");
    exit();
}

/*
    Load all flashcards for this deck
*/
$stmt = $conn->prepare(
    "SELECT front, back
     FROM TblCards
     WHERE deck_id = :deck_id"
);
$stmt->bindParam(":deck_id", $deck_id);
$stmt->execute();
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null;

// Track current question index using session
if (!isset($_SESSION['test_index'])) {
    $_SESSION['test_index'] = 0;
}

// Move to next question
if (isset($_POST['next'])) {
    $_SESSION['test_index']++;
}

// Reset if end reached
if ($_SESSION['test_index'] >= count($cards)) {
    $_SESSION['test_index'] = 0;
}

$current = $cards[$_SESSION['test_index']] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Memoly | Test Mode</title>
</head>

<body>

<h2>Test Mode: <?php echo htmlspecialchars($deck['title']); ?></h2>

<?php if (!$current): ?>
    <p>No flashcards in this set.</p>
    <a href="library.php">Back to library</a>

<?php else: ?>

    <!-- Question -->
    <h3>Question</h3>
    <p><?php echo htmlspecialchars($current['front']); ?></p>

    <!-- Answer (hidden by default) -->
    <?php if (isset($_POST['show'])): ?>
        <h3>Answer</h3>
        <p><?php echo htmlspecialchars($current['back']); ?></p>
    <?php endif; ?>

    <form method="post">
        <?php if (!isset($_POST['show'])): ?>
            <button type="submit" name="show">Show Answer</button>
        <?php else: ?>
            <button type="submit" name="next">Next Question</button>
        <?php endif; ?>
    </form>

<?php endif; ?>

<br>
<a href="library.php">← Back to Library</a>

</body>
</html>