<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "memoly"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert into Users
    $conn->exec("
        INSERT INTO Users (name, username, email, password, is_teacher)
        VALUES ('Andy', 'ChenY', 'abc@outlook.com', 'Smq123!', TRUE)
    ");

    // Insert into Topic
    $conn->exec("
        INSERT INTO Topic (topic_id, topic_name)
        VALUES (252, 'Chinese')
    ");

    // Insert into Decks
    $conn->exec("
        INSERT INTO Decks (user_id, title, description, created_at, topic_id)
        VALUES (1, 'Spanish topic 3', 'Key vocabs from topic 3', '250501', 252)
    ");

    // Insert into Cards
    $conn->exec("
        INSERT INTO Cards (deck_id, front, back, pic, topic_id)
        VALUES (1, 'Apple', 'A type of fruit', '', 252)
    ");

    // Insert into StudySession
    $conn->exec("
        INSERT INTO StudySession (user_id, deck_id, starttime, endtime, teacher_set, score)
        VALUES (1, 1, NOW(), NOW(), TRUE, 100)
    ");

    echo "Sample data added successfully. :)";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>