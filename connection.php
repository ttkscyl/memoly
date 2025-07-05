<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoly";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully!"; // comment after testing is done
} 

catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
# /Applications/XAMPP/xamppfiles/bin/mysql -u root
# MacOS login to databse
?>