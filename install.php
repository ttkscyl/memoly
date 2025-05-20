<?php
include_once("connection.php");


// 1. Users Table
$stmt = $conn->prepare("
    DROP TABLE IF EXISTS Users;
    CREATE TABLE Users (
        user_id INT(6) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30),
        username VARCHAR(30) UNIQUE,
        email VARCHAR(30) UNIQUE,
        password VARCHAR(200) NOT NULL,
        is_teacher BOOLEAN NOT NULL,
    )
");
$stmt->execute();
$stmt->closeCursor();
echo ("<br>1. Users table created");


// 2. Decks Table
$stmt = $conn->prepare("
    DROP TABLE IF EXISTS Decks;
    CREATE TABLE Decks (
        deck_id INT(4) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6),
        title VARCHAR(30) NOT NULL,
        description VARCHAR(100),
        created_at VARCHAR(6) NOT NULL,
        topic_id INT(3),
    )
");
$stmt->execute();
$stmt->closeCursor();
echo ("<br>2. Decks table created");


// 3. Cards Table
$stmt = $conn->prepare("
    DROP TABLE IF EXISTS Cards;
    CREATE TABLE Cards (
        card_id INT(20) AUTO_INCREMENT PRIMARY KEY,
        deck_id INT(4),
        front VARCHAR(100),
        back VARCHAR(1000) NOT NULL,
        pic VARCHAR(1000),
        topic_id INT(3),
    )
");
$stmt->execute();
$stmt->closeCursor();
echo ("<br>3. BorrowingRecords table created");


// 4. Study Session Table
$stmt = $conn->prepare("
    DROP TABLE IF EXISTS StudySession;
    CREATE TABLE StudySession (
        session_id INT(4) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6),
        deck_id INT(4),
        starttime DATETIME,
        endtime DATETIME,
        teacher_set BOOLEAN,
        score INT(3),
    )
");
$stmt->execute();
$stmt->closeCursor();
echo ("<br>4. StudySession table created");


// 5. Topic Table
$stmt = $conn->prepare("
    DROP TABLE IF EXISTS Topic;
    CREATE TABLE Topic (
        topic_id INT(3) UNIQUE,
        topic_name VARCHAR(200)
    )
");
$stmt->execute();
$stmt->closeCursor();
echo ("<br>5. StudySession table created");