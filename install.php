<?php
// Server login
$servername = 'localhost';
$username   = 'root';
$password   = '';

try {
    // Login to server and create database if not already exists
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS Flashcards";
    $conn->exec($sql);

    $sql = "USE Flashcards";
    $conn->exec($sql);

    echo "DB created successfully<br>";

    /* =========================
       CREATE USERS TABLE
    ========================== */
    $stmt = $conn->prepare("
        DROP TABLE IF EXISTS TblUsers;
        CREATE TABLE TblUsers (
            UserID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Email VARCHAR(50) NOT NULL,
            Username VARCHAR(120) NOT NULL,
            Password VARCHAR(200) NOT NULL
        )
    ");
    $stmt->execute();
    $stmt->closeCursor();

    /* =========================
       CREATE SETS TABLE
    ========================== */
    $stmt2 = $conn->prepare("
        DROP TABLE IF EXISTS TblSets;
        CREATE TABLE TblSets (
            SetID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            SetName VARCHAR(50) NOT NULL,
            UserID INT(6) NOT NULL,
            Public INT(1) NOT NULL DEFAULT 0,
            SetDescription VARCHAR(100) NOT NULL
        )
    ");
    $stmt2->execute();
    $stmt2->closeCursor();

    /* =========================
       USER STUDIES TABLE
    ========================== */
    $stmt7 = $conn->prepare("
        DROP TABLE IF EXISTS TblUserStudies;
        CREATE TABLE TblUserStudies (
            UserID INT(6) NOT NULL,
            SetID INT(10) NOT NULL,
            Visits INT(10) DEFAULT 0,
            TimeStart DATETIME,
            TimeFinish DATETIME,
            PRIMARY KEY (UserID, SetID)
        )
    ");
    $stmt7->execute();
    $stmt7->closeCursor();

    /* =========================
       TEST RESULTS TABLE
    ========================== */
    $stmt7 = $conn->prepare("
        DROP TABLE IF EXISTS TblTests;
        CREATE TABLE TblTests (
            UserID INT(6) NOT NULL,
            SetID INT(10) NOT NULL,
            Score INT(10) DEFAULT 0,
            Date DATETIME,
            PRIMARY KEY (UserID, SetID, Date)
        )
    ");
    $stmt7->execute();
    $stmt7->closeCursor();

    /* =========================
       INSERT TEST USERS
    ========================== */
    $hashed_password = password_hash("password", PASSWORD_DEFAULT);

    $stmt9 = $conn->prepare("
        INSERT INTO TblUsers (UserID, Username, Email, Password) VALUES
        (NULL, 'Focus.l', 'lamitiapont.m@oundleschool.org.uk', :pword),
        (NULL, 'Liv.X', 'liv.xu@gmail.com', :pword)
    ");
    $stmt9->bindParam(':pword', $hashed_password);
    $stmt9->execute();
    $stmt9->closeCursor();

    /* =========================
       INSERT TEST SETS
    ========================== */
    $stmt10 = $conn->prepare("
        INSERT INTO TblSets (SetID, SetName, UserID, Public, SetDescription) VALUES
        (NULL, 'Primary Storage', 1, 1, 'RAM ROM etc'),
        (NULL, 'Cell Structures', 1, 1, 'Eukaryotes')
    ");
    $stmt10->execute();
    $stmt10->closeCursor();

    /* =========================
       INSERT FLASHCARDS
    ========================== */
    $stmt12 = $conn->prepare("
        INSERT INTO TblCards (CardID, Term, Definition) VALUES
        (NULL, 'MITOCHONDRIA', 'PRODUCES ATP'),
        (NULL, 'Vacuole', 'A HOLE IN PLANT CELL'),
        (NULL, 'Cell wall', 'MADE OF CELLULOSE'),
        (NULL, 'Golgi Body', 'PACKAGE PROTEIN'),
        (NULL, 'Lysosome', 'CONTAINS LYSOZYMES')
    ");
    $stmt12->execute();
    $stmt12->closeCursor();

    /* =========================
       LINK CARDS TO SETS
    ========================== */
    $stmt13 = $conn->prepare("
        INSERT INTO TblSetContent (SetID, CardID) VALUES
        (2, 1),
        (2, 2),
        (2, 3),
        (2, 4),
        (2, 5)
    ");
    $stmt13->execute();
    $stmt13->closeCursor();

} catch (PDOException $e) {
    echo "Error:<br>" . $e->getMessage();
}

$conn = null;
?>
