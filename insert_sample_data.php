<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "memoly"; 

// Users
$sql = "INSERT INTO Users (name, username, email, password, is_teacher)
        VALUES ('Andy', 'ChenY', 'abc@outlook.com', 'Smq123!', TRUE)";
$conn->query($sql);

// Topic
$sql = "INSERT INTO Topic (topic_id, topic_name)
        VALUES (252, 'Chinese')";
$conn->query($sql);

// Decks
$sql = "INSERT INTO Decks (user_id, title, description, created_at, topic_id)
        VALUES (1, 'Spanish topic 3', 'Key vocabs from topic 3', '250501', 252)";
$conn->query($sql);

// Cards
$sql = "INSERT INTO Cards (deck_id, front, back, pic, topic_id)
        VALUES (1, 'Apple', 'A type of fruit', '', 252)";
$conn->query($sql);

// StudySessions
$sql = "INSERT INTO StudySessions (user_id, deck_id, starttime, endtime, teacher_set, score)
        VALUES (1, 1, NOW(), NOW(), TRUE, 100)";
$conn->query($sql);


echo "Sample data inserted successfully.";

$conn->close();
?>
