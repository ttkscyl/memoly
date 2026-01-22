<?php
try {
    // Connect to the database
    include_once('connection.php');

    /*
        Server-side validation to ensure required fields are not empty.
        This prevents users from bypassing client-side validation.
    */
    if (
        empty($_POST['name']) ||
        empty($_POST['username']) ||
        empty($_POST['email']) ||
        empty($_POST['password'])
    ) {
        header("Location: users.php?error=emptyfields");
        exit();
    }

    /*
        Hash the password before storing it in the database.
        This ensures passwords are never stored in plain text.
    */
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    /*
        Set teacher role:
        1 if checkbox is checked, otherwise 0.
    */
    $is_teacher = isset($_POST["is_teacher"]) ? 1 : 0;

    /*
        Prepare SQL statement using placeholders
        to prevent SQL injection.
    */
    $stmt = $conn->prepare(
        "INSERT INTO TblUsers (name, username, email, password, is_teacher)
         VALUES (:name, :username, :email, :password, :is_teacher)"
    );

    // Bind user input to SQL parameters
    $stmt->bindParam(':name', $_POST["name"]);
    $stmt->bindParam(':username', $_POST["username"]);
    $stmt->bindParam(':email', $_POST["email"]);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':is_teacher', $is_teacher, PDO::PARAM_BOOL);

    // Execute the insert query
    $stmt->execute();

    // Redirect back to sign-up page with success message
    header("Location: users.php?success=1");
    exit();

}
catch (PDOException $e) {
    // Redirect back with error if insertion fails
    header("Location: users.php?error=1");
    exit();
}

// Close database connection
$conn = null;
?>