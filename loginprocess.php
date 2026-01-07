<?php
// Start session to allow user login state to be stored
session_start();

// Include database connection
include_once("connection.php");

/*
    Server-side validation to ensure fields are not empty.
    This prevents users from bypassing JavaScript validation
    and improves system robustness.
*/
if (empty($_POST['Username']) || empty($_POST['password'])) {
    header("Location: login.php?error=emptyfields");
    exit();
}

/*
    Prepare SQL statement to safely retrieve user record
    using a prepared statement to prevent SQL injection.
*/
$stmt = $conn->prepare("SELECT * FROM TblUsers WHERE username = :Username");
$stmt->bindParam(":Username", $_POST['Username']);
$stmt->execute();

// Fetch the user record as an associative array
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Retrieve hashed password from database
    $hashed = $user['password'];
    $attempt = $_POST['password'];

    /*
        Verify the entered password against the stored hash.
        password_verify() is a built-in PHP function designed
        for secure authentication.
    */
    if (password_verify($attempt, $hashed)) {

        // Store the logged-in user's ID in the session
        $_SESSION['CurrentUser'] = $user['user_id'];

        /*
            Redirect user back to the page they originally
            attempted to access, or to the homepage if none exists.
        */
        $backURL = isset($_SESSION['backURL']) ? $_SESSION['backURL'] : "index.php";
        unset($_SESSION['backURL']);

        header("Location: " . $backURL);
        exit();

    } else {
        // Password does not match the stored hash
        header("Location: login.php?error=invalidpassword");
        exit();
    }

} else {
    // No matching username found in the database
    header("Location: login.php?error=usernotfound");
    exit();
}

// Close database connection
$conn = null;