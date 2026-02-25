<?php

// Login details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoly";

try {
    // Create PDO connection with UTF-8 encoding
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Enable exception mode so errors are easier to identify during development
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // For testing during development, comment after development complete
    echo "Connected successfully!"; 

} catch (PDOException $e) {
    // Display full error message while developing to help debugging
    echo "Connection failed: " . $e->getMessage();
}

?>