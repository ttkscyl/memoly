<?php
include_once("connection.php");

// 1. Users Table
$conn->exec("DROP TABLE IF EXISTS Users");
$conn->exec("
   CREATE TABLE Users (
       user_id INT(6) AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(30),
       username VARCHAR(30) UNIQUE,
       email VARCHAR(30) UNIQUE,
       password VARCHAR(200) NOT NULL,
       is_teacher BOOLEAN NOT NULL
   )
");
echo "<br>1. Users table created";

// 2. Decks Table
$conn->exec("DROP TABLE IF EXISTS Decks");
$conn->exec("
   CREATE TABLE Decks (
       deck_id INT(4) AUTO_INCREMENT PRIMARY KEY,
       user_id INT(6),
       title VARCHAR(30) NOT NULL,
       description VARCHAR(100),
       created_at VARCHAR(6) NOT NULL,
       topic_id INT(3)
   )
");
echo "<br>2. Decks table created";

// 3. Cards Table
$conn->exec("DROP TABLE IF EXISTS Cards");
$conn->exec("
   CREATE TABLE Cards (
       card_id INT(20) AUTO_INCREMENT PRIMARY KEY,
       deck_id INT(4),
       front VARCHAR(100),
       back VARCHAR(1000) NOT NULL,
       pic VARCHAR(1000),
       topic_id INT(3)
   )
");
echo "<br>3. Cards table created";

// 4. StudySession Table
$conn->exec("DROP TABLE IF EXISTS StudySession");
$conn->exec("
   CREATE TABLE StudySession (
       session_id INT(4) AUTO_INCREMENT PRIMARY KEY,
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
$conn->exec("DROP TABLE IF EXISTS Topic");
$conn->exec("
   CREATE TABLE Topic (
       topic_id INT(3) AUTO_INCREMENT PRIMARY KEY,
       topic_name VARCHAR(200)
   )
");
echo "<br>5. Topic table created";

// 6. Folders Table
$conn->exec("DROP TABLE IF EXISTS Folders");
$conn->exec("
    CREATE TABLE Folders (
        folder_id INT(4) AUTO_INCREMENT PRIMARY KEY,
        folder_name VARCHAR(30) NOT NULL,
        folder_description VARCHAR(100),
        deck_id INT(4) UNIQUE
    )
");
echo "<br>6. Folders table created";