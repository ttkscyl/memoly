<?php
// Start session to identify the logged-in user
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

include_once("connection.php");

/*
    Get decks (sets) that belong to the logged-in user.
    This ensures the user can only add cards to their own decks.
*/
$stmt = $conn->prepare(
    "SELECT deck_id, title
     FROM TblDecks
     WHERE user_id = :user_id
     ORDER BY created_at DESC"
);
$stmt->bindParam(":user_id", $_SESSION['CurrentUser']);
$stmt->execute();
$decks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Memoly | Create Flashcard</title>
</head>

<body>

<h2>Create a New Flashcard</h2>

<!-- Display feedback messages -->
<?php
if (isset($_GET['success'])) {
    echo "<p style='color:green;'>Flashcard created successfully.</p>";
} elseif (isset($_GET['error'])) {
    echo "<p style='color:red;'>Error creating flashcard. Please try again.</p>";
}
?>

<!-- Form to create a flashcard -->
<form action="addcards.php" method="POST">

    <!-- Deck selection dropdown -->
    <label for="deck_id">Select Set (Deck):</label><br>
    <select name="deck_id" required>
        <option value="">-- Choose a Set --</option>

        <?php
        // Populate dropdown with user's decks
        foreach ($decks as $deck) {
            echo "<option value='{$deck['deck_id']}'>{$deck['title']}</option>";
        }
        ?>
    </select>
    <br><br>

    <!-- Front of the flashcard -->
    <label for="front">Front:</label><br>
    <input type="text" name="front" placeholder="Front (question/term)" required>
    <br><br>

    <!-- Back of the flashcard -->
    <label for="back">Back:</label><br>
    <textarea name="back" placeholder="Back (definition/answer)" rows="5" cols="40" required></textarea>
    <br><br>

    <!-- Optional image path (simple approach for coursework) -->
    <label for="pic">Image (optional file path/URL):</label><br>
    <input type="text" name="pic" placeholder="e.g. uploads/image.png">
    <br><br>

    <button type="submit">Create Flashcard</button>
</form>

</body>
</html>

<?php
// Close connection
$conn = null;
?>