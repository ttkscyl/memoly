<?php

require_once "connection.php";
session_start();  // Start session to store login information

$username = $_POST['username'];
$password = $_POST['password'];

try {

    // Retrieve user record using prepared statement
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if ($user) {

        // Verify entered password against stored hashed password
        if (password_verify($password, $user['Password'])) {

            // Store user information in session variables
            $_SESSION['UserID'] = $user['UserID'];
            $_SESSION['Username'] = $user['Username'];
            $_SESSION['IsTeacher'] = $user['IsTeacher'];

            echo "Login successful.";

        } else {
            echo "Incorrect password.";
        }

    } else {
        echo "User not found.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>