<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoly";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully!"; // 测试完成后注释
} 

catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>