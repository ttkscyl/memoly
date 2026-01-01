<?php
// Login Process takes in the inputs and checks the validity before starting a session
session_start();

// Connects to DB
include_once("connection.php");

// Sanitize POST data
array_map("htmlspecialchars", $_POST);

// Query with posted Username. This also checks the validity of the inputs
$stmt = $conn->prepare("SELECT * FROM TblUsers WHERE Username = :Username");
$stmt->bindParam(':Username', $_POST['Username']);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $hashed  = $row['Password'];
    $attempt = $_POST['password'];

    // Check password validity - directs to login page if incorrect
    if (password_verify($attempt, $hashed)) {

        $_SESSION['CurrentUser'] = $row['UserID'];

        if (!isset($_SESSION['backURL'])) {
            $backURL = "homepage.php";
        } else {
            $backURL = $_SESSION['backURL'];
        }

        unset($_SESSION['backURL']);
        header("Location: " . $backURL);
        echo "loggedin";

    } else {
        echo "password error";
        header("Location: login.php");
    }
}

$conn = null;
?>
