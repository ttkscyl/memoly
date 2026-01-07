<?php
// install.php
// Creates the database tables for the Flashcards project (6-table schema)

include_once("connection.php");

// Ensure PDO throws errors automatically
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// -------------------------
// DROP TABLES (child → parent)
// -------------------------
$conn->exec("DROP TABLE IF EXISTS TblStudySessions");
$conn->exec("DROP TABLE IF EXISTS TblCards");
$conn->exec("DROP TABLE IF EXISTS TblDecks");
$conn->exec("DROP TABLE IF EXISTS TblFolders");
$conn->exec("DROP TABLE IF EXISTS TblTopics");
$conn->exec("DROP TABLE IF EXISTS TblUsers");

$conn->exec("SET FOREIGN_KEY_CHECKS = 1");

// -------------------------
// 1) TblUsers
// -------------------------
$conn->exec("
    CREATE TABLE TblUsers (
        user_id INT(6) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50),
        username VARCHAR(30) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_teacher BOOLEAN NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
echo "<br>1. TblUsers created";

// -------------------------
// 2) TblTopics
// -------------------------
$conn->exec("
    CREATE TABLE TblTopics (
        topic_id INT(3) AUTO_INCREMENT PRIMARY KEY,
        topic_name VARCHAR(50) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
echo "<br>2. TblTopics created";

// -------------------------
// 3) TblFolders
// -------------------------
$conn->exec("
    CREATE TABLE TblFolders (
        folder_id INT(6) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) NOT NULL,
        folder_name VARCHAR(30) NOT NULL,
        folder_description VARCHAR(100),

        FOREIGN KEY (user_id) REFERENCES TblUsers(user_id)
        ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
echo "<br>3. TblFolders created";

// -------------------------
// 4) TblDecks
// -------------------------
$conn->exec("
    CREATE TABLE TblDecks (
        deck_id INT(6) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) NOT NULL,
        folder_id INT(6),
        topic_id INT(3),
        title VARCHAR(60) NOT NULL,
        description VARCHAR(100),
        is_public BOOLEAN NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        FOREIGN KEY (user_id) REFERENCES TblUsers(user_id)
            ON DELETE CASCADE,
        FOREIGN KEY (folder_id) REFERENCES TblFolders(folder_id)
            ON DELETE SET NULL,
        FOREIGN KEY (topic_id) REFERENCES TblTopics(topic_id)
            ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
echo "<br>4. TblDecks created";

// -------------------------
// 5) TblCards
// -------------------------
$conn->exec("
    CREATE TABLE TblCards (
        card_id INT(10) AUTO_INCREMENT PRIMARY KEY,
        deck_id INT(6) NOT NULL,
        front VARCHAR(150) NOT NULL,
        back VARCHAR(1000) NOT NULL,
        pic VARCHAR(255),

        FOREIGN KEY (deck_id) REFERENCES TblDecks(deck_id)
            ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
echo "<br>5. TblCards created";

// -------------------------
// 6) TblStudySessions
// -------------------------
$conn->exec("
    CREATE TABLE TblStudySessions (
        session_id INT(8) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) NOT NULL,
        deck_id INT(6) NOT NULL,
        start_time DATETIME NOT NULL,
        end_time DATETIME,
        score INT(3),

        FOREIGN KEY (user_id) REFERENCES TblUsers(user_id)
            ON DELETE CASCADE,
        FOREIGN KEY (deck_id) REFERENCES TblDecks(deck_id)
            ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");
echo "<br>6. TblStudySessions created";

echo "<br><br><strong>✅ Installation complete — all 6 tables created successfully.</strong>";
?>