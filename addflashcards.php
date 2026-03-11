<?php

require_once "connection.php";
require_once "navbar.php";
session_start();

// Ensure user is logged in
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $term = $_POST['term'];
    $definition = $_POST['definition'];
    $setid = $_POST['setid'];

    try {

        // Insert flashcard into database
        $stmt = $conn->prepare(
            "INSERT INTO Flashcards (SetID, Term, Definition) VALUES (?, ?, ?)"
        );

        $stmt->execute([$setid, $term, $definition]);

        echo "Flashcard created successfully.";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}

?>