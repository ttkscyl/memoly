<?php

require_once "connection.php";

try {

    // Users table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS Users (
            UserID INT AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(50) NOT NULL UNIQUE,
            Email VARCHAR(100) NOT NULL UNIQUE,
            Password VARCHAR(255) NOT NULL,
            IsTeacher BOOLEAN NOT NULL DEFAULT 0
        )
    ");

    // Folders table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS Folders (
            FolderID INT AUTO_INCREMENT PRIMARY KEY,
            FolderName VARCHAR(100) NOT NULL,
            UserID INT NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(UserID)
        )
    ");

    // Sets table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS Sets (
            SetID INT AUTO_INCREMENT PRIMARY KEY,
            SetName VARCHAR(100) NOT NULL,
            FolderID INT NOT NULL,
            UserID INT NOT NULL,
            FOREIGN KEY (FolderID) REFERENCES Folders(FolderID),
            FOREIGN KEY (UserID) REFERENCES Users(UserID)
        )
    ");

    // Flashcards table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS Flashcards (
            CardID INT AUTO_INCREMENT PRIMARY KEY,
            SetID INT NOT NULL,
            Term VARCHAR(255) NOT NULL,
            Definition TEXT NOT NULL,
            FOREIGN KEY (SetID) REFERENCES Sets(SetID)
        )
    ");

    // Classes table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS Classes (
            ClassID INT AUTO_INCREMENT PRIMARY KEY,
            TeacherID INT NOT NULL,
            FOREIGN KEY (TeacherID) REFERENCES Users(UserID)
        )
    ");

    // Many-to-many relationship table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS UserInClass (
            UserID INT NOT NULL,
            ClassID INT NOT NULL,
            PRIMARY KEY (UserID, ClassID),
            FOREIGN KEY (UserID) REFERENCES Users(UserID),
            FOREIGN KEY (ClassID) REFERENCES Classes(ClassID)
        )
    ");

    // Test sessions table
    $conn->exec("
        CREATE TABLE IF NOT EXISTS Test (
            TestID INT AUTO_INCREMENT PRIMARY KEY,
            UserID INT NOT NULL,
            SetID INT NOT NULL,
            TimeStart DATETIME NOT NULL,
            TimeFinish DATETIME NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(UserID),
            FOREIGN KEY (SetID) REFERENCES Sets(SetID)
        )
    ");

    echo "Installation completed successfully.";

} catch (PDOException $e) {
    echo "Installation failed: " . $e->getMessage();
}

?>