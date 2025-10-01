<?php
include_once("connection.php");

// 1. Users Table
$conn->exec("DROP TABLE IF EXISTS TblUsers");
$conn->exec("
    CREATE TABLE TblUsers (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30),
        username VARCHAR(30) UNIQUE,
        email VARCHAR(30) UNIQUE,
        password VARCHAR(200) NOT NULL,
        is_teacher BOOLEAN NOT NULL DEFAULT 0
    )
");
echo "<br>1. Users table created";

// 2. Decks Table
$conn->exec("DROP TABLE IF EXISTS TblDecks");
$conn->exec("
    CREATE TABLE TblDecks (
        deck_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6),
        title VARCHAR(30) NOT NULL,
        description VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        topic_id INT(3)
    )
");
echo "<br>2. Decks table created";

// 3. Cards Table
$conn->exec("DROP TABLE IF EXISTS TblCards");
$conn->exec("
    CREATE TABLE TblCards (
        card_id INT AUTO_INCREMENT PRIMARY KEY,
        deck_id INT(4),
        front VARCHAR(100),
        back VARCHAR(1000) NOT NULL,
        pic VARCHAR(1000),
        topic_id INT(3)
    )
");
echo "<br>3. Cards table created";

// 4. StudySession Table
$conn->exec("DROP TABLE IF EXISTS TblStudySession");
$conn->exec("
    CREATE TABLE TblStudySession (
        session_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6),
        deck_id INT(4),
        starttime DATETIME,
        endtime DATETIME,
        teacher_set BOOLEAN,
        score INT(3)
    )
");
echo "<br>4. StudySession table created";

// 5. Topic Table
$conn->exec("DROP TABLE IF EXISTS TblTopic");
$conn->exec("
    CREATE TABLE TblTopic (
        topic_id INT AUTO_INCREMENT PRIMARY KEY,
        topic_name VARCHAR(200)
    )
");
echo "<br>5. Topic table created";

// 6. Folders Table
$conn->exec("DROP TABLE IF EXISTS TblFolders");
$conn->exec("
    CREATE TABLE TblFolders (
        folder_id INT AUTO_INCREMENT PRIMARY KEY,
        folder_name VARCHAR(30) NOT NULL,
        folder_description VARCHAR(100),
        deck_id INT(4)
    )
");
echo "<br>6. Folders table created";
?>