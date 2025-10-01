<?php
include_once("connection.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoly";

try {
    // --- Insert Users ---
    $conn->exec("
        INSERT INTO TblUsers (name, username, email, password, is_teacher) VALUES
        ('Alice Johnson', 'alice', 'alice@example.com', '" . password_hash("password123", PASSWORD_DEFAULT) . "', 0),
        ('Bob Smith', 'bob', 'bob@example.com', '" . password_hash("securepass", PASSWORD_DEFAULT) . "', 0),
        ('Mr. Brown', 'teacher1', 'teacher@example.com', '" . password_hash("teachpass", PASSWORD_DEFAULT) . "', 1)
    ");
    echo "<br>Sample users inserted.";

    // --- Insert Topics ---
    $conn->exec("
        INSERT INTO TblTopic (topic_name) VALUES
        ('Biology'),
        ('History'),
        ('Mathematics')
    ");
    echo "<br>Sample topics inserted.";

    // --- Insert Decks ---
    $conn->exec("
        INSERT INTO TblDecks (user_id, title, description, topic_id) VALUES
        (1, 'Biology Basics', 'Intro to Biology flashcards', 1),
        (2, 'World War II', 'Important WWII events and dates', 2),
        (3, 'Algebra I', 'Basic algebra concepts', 3)
    ");
    echo "<br>Sample decks inserted.";

    // --- Insert Cards ---
    $conn->exec("
        INSERT INTO TblCards (deck_id, front, back, pic, topic_id) VALUES
        (1, 'Cell', 'The basic unit of life', NULL, 1),
        (1, 'DNA', 'Molecule that carries genetic instructions', NULL, 1),
        (2, '1945', 'End of World War II', NULL, 2),
        (2, '1939', 'Start of World War II', NULL, 2),
        (3, 'x + 2 = 5', 'x = 3', NULL, 3),
        (3, '2x = 10', 'x = 5', NULL, 3)
    ");
    echo "<br>Sample cards inserted.";

    // --- Insert Study Sessions ---
    $conn->exec("
        INSERT INTO TblStudySession (user_id, deck_id, starttime, endtime, teacher_set, score) VALUES
        (1, 1, '2025-10-01 10:00:00', '2025-10-01 10:30:00', 0, 85),
        (2, 2, '2025-10-01 11:00:00', '2025-10-01 11:25:00', 0, 90),
        (3, 3, '2025-10-01 09:00:00', '2025-10-01 09:45:00', 1, 100)
    ");
    echo "<br>Sample study sessions inserted.";

    // --- Insert Folders ---
    $conn->exec("
        INSERT INTO TblFolders (folder_name, folder_description, deck_id) VALUES
        ('Biology Folder', 'Contains biology-related decks', 1),
        ('History Folder', 'Contains history-related decks', 2),
        ('Math Folder', 'Contains math-related decks', 3)
    ");
    echo "<br>Sample folders inserted.";
} catch (PDOException $e) {
    echo "<br>Error inserting data: " . $e->getMessage();
}

$conn = null;
?>