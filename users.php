<?php require_once "navbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    
    <br>

    <h2>Create an Account</h2>

    <form action="addusers.php" method="POST">

        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Are you a teacher?</label><br>
        <select name="isteacher">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select><br><br>

        <input type="submit" value="Sign Up">

    </form>

</body>
</html>