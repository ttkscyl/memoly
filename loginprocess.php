<?php
session_start();

// Connect to DB
include_once("connection.php");
array_map("htmlspecialchars", $_POST);

// Prepare and run the query
$stmt = $conn->prepare("SELECT * FROM TblUsers WHERE username = :Username");
$stmt->bindParam(":Username", $_POST['Username']);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $hashed = $user['password'];
    $attempt = $_POST['password'];

    if (password_verify($attempt, $hashed)) {
        // Password correct - start session
        $_SESSION['CurrentUser'] = $user['user_id'];

        // Redirect to original page or homepage
        $backURL = isset($_SESSION['backURL']) ? $_SESSION['backURL'] : "index.php";
        unset($_SESSION['backURL']);

        header("Location: " . $backURL);
        exit();
    } else {
        // Password incorrect
        header("Location: login.php?error=invalidpassword");
        exit();
    }
} else {
    // Username not found
    header("Location: login.php?error=usernotfound");
    exit();
}

$conn = null;