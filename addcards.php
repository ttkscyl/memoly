<?php
/*
    addcards.php
    Inserts a new flashcard into TblCards.
    The flashcard is linked to a deck chosen by the user.
*/

session_start();

// Ensure user is logged in
if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

try {
    include_once("connection.php");

    /*
        Server-side validation:
        Ensure required fields are not empty.
    */
    if (empty($_POST['deck_id']) || empty($_POST['front']) || empty($_POST['back'])) {
        header("Location: cards.php?error=emptyfields");
        exit();
    }

    /*
        Security check:
        Confirm the selected deck belongs to the logged-in user.
        This prevents users adding cards to someone else's deck.
    */
    $check = $conn->prepare(
        "SELECT deck_id FROM TblDecks
         WHERE deck_id = :deck_id AND user_id = :user_id"
    );
    $check->bindParam(":deck_id", $_POST['deck_id']);
    $check->bindParam(":user_id", $_SESSION['CurrentUser']);
    $check->execute();

    if (!$check->fetch(PDO::FETCH_ASSOC)) {
        // Deck does not belong to the user (or doesn't exist)
        header("Location: cards.php?error=invaliddeck");
        exit();
    }

    /*
        Insert the flashcard into TblCards.
        'pic' is optional so NULL is allowed.
    */
    $pic_value = !empty($_POST['pic']) ? $_POST['pic'] : NULL;

    $stmt = $conn->prepare(
        "INSERT INTO TblCards (deck_id, front, back, pic)
         VALUES (:deck_id, :front, :back, :pic)"
    );

    $stmt->bindParam(":deck_id", $_POST['deck_id']);
    $stmt->bindParam(":front", $_POST['front']);
    $stmt->bindParam(":back", $_POST['back']); // back is VARCHAR(1000) in your DB
    $stmt->bindParam(":pic", $pic_value);

    $stmt->execute();

    // Redirect back with success message
    header("Location: cards.php?success=1");
    exit();

} catch (PDOException $e) {
    // Redirect back with error
    header("Location: cards.php?error=1");
    exit();
}

$conn = null;
?>