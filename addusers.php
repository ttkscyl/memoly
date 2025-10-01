<?php
// Sends HTTP header to the browser to redirect to users.php
header('Location: users.php');

try {
    include_once('connection.php');

    // Password hashed for security
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Set is_teacher (1 if checkbox checked, otherwise 0)
    $is_teacher = isset($_POST["is_teacher"]) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO TblUsers (name, username, email, password, is_teacher) 
							VALUES (:name, :username, :email, :password, :is_teacher)");

    // Bind parameters
    $stmt->bindParam(':name', $_POST["name"]);
    $stmt->bindParam(':username', $_POST["username"]);
    $stmt->bindParam(':email', $_POST["email"]);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':is_teacher', $is_teacher, PDO::PARAM_BOOL);

    $stmt->execute();
}
catch(PDOException $e) {
    echo "error" . $e->getMessage();
}

$conn = null;
?>