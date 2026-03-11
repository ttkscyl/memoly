<?php

require_once "connection.php";
require_once "navbar.php";

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$isteacher = $_POST['isteacher'];

// Hash password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {

    // Check if username or email already exists
    $check = $conn->prepare("SELECT * FROM Users WHERE Username = ? OR Email = ?");
    $check->execute([$username, $email]);

    if ($check->rowCount() > 0) {
        echo "Username or Email already exists.";
    } else {

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO Users (Username, Email, Password, IsTeacher) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $isteacher]);

        echo "Account created successfully.";

    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>