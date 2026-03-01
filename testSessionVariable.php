<?php

session_start();  // Activate session system

echo "<h2>Session Variable Test Page</h2>";

// Check if UserID session variable exists
if (isset($_SESSION['UserID'])) {
    echo "UserID session is active.<br>";
    echo "UserID: " . $_SESSION['UserID'] . "<br>";
} else {
    echo "UserID session is NOT active.<br>";
}

// Check if Username session variable exists
if (isset($_SESSION['Username'])) {
    echo "Username session is active.<br>";
    echo "Username: " . $_SESSION['Username'] . "<br>";
} else {
    echo "Username session is NOT active.<br>";
}

// Check if IsTeacher session variable exists
if (isset($_SESSION['IsTeacher'])) {
    echo "IsTeacher session is active.<br>";
    echo "IsTeacher value: " . $_SESSION['IsTeacher'] . "<br>";
} else {
    echo "IsTeacher session is NOT active.<br>";
}

?>