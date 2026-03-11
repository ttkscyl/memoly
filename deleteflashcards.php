<?php
require_once "connection.php";
require_once "navbar.php";

$cardid = $_POST['cardid'];
$setid = $_POST['setid'];

// Delete selected flashcard
$stmt = $conn->prepare("DELETE FROM Flashcards WHERE CardID = ?");
$stmt->execute([$cardid]);

// Redirect back to edit page
header("Location: editflashcards.php?setid=" . $setid);
exit();
?>