<?php
// insert_test_data.php
// Inserts test data for the Flashcards project

include_once("connection.php");

// Ensure errors show
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// -------------------------
// 1) Insert Users
// -------------------------
$conn->exec("
    INSERT INTO TblUsers (name, username, email, password, is_teacher)
    VALUES
    ('Andy Chen', 'yilangc', 'yilangc@email.com', '$2y$10$testhash1234567890', 0),
    ('Mrs Mansergh', 'teacher1', 'teacher@email.com', '$2y$10$testhash0987654321', 1)
");
echo "<br>1. Test users inserted";

// -------------------------
// 2) Insert Topics
// -------------------------
$conn->exec("
    INSERT INTO TblTopics (topic_name)
    VALUES
    ('Biology'),
    ('Computer Science'),
    ('Geography')
");
echo "<br>2. Test topics inserted";

// -------------------------
// 3) Insert Folders
// -------------------------
$conn->exec("
    INSERT INTO TblFolders (user_id, folder_name, folder_description)
    VALUES
    (1, 'Biology Revision', 'Key biology topics'),
    (1, 'Computer Science', 'A level CS content')
");
echo "<br>3. Test folders inserted";

// -------------------------
// 4) Insert Decks
// -------------------------
$conn->exec("
    INSERT INTO TblDecks (user_id, folder_id, topic_id, title, description, is_public)
    VALUES
    (1, 1, 1, 'Cell Structure', 'Key cell organelles', 0),
    (1, 2, 2, 'Primary Storage', 'Types of primary storage', 1)
");
echo "<br>4. Test decks inserted";

// -------------------------
// 5) Insert Cards
// -------------------------
$conn->exec("
    INSERT INTO TblCards (deck_id, front, back, pic)
    VALUES
    (1, 'Mitochondria', 'Organelle responsible for aerobic respiration', NULL),
    (1, 'Nucleus', 'Controls the activities of the cell', NULL),
    (2, 'RAM', 'Random Access Memory', NULL),
    (2, 'ROM', 'Read Only Memory', NULL)
");
echo "<br>5. Test cards inserted";

// -------------------------
// 6) Insert Study Sessions
// -------------------------
$conn->exec("
    INSERT INTO TblStudySessions (user_id, deck_id, start_time, end_time, score)
    VALUES
    (1, 1, '2026-01-02 10:15:00', '2026-01-02 10:35:00', 85),
    (1, 2, '2026-01-03 14:00:00', '2026-01-03 14:25:00', 92)
");
echo "<br>6. Test study sessions inserted";

echo "<br><br><strong>Test data inserted successfully.</strong>";
?>