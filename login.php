<?php require_once "navbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <br>
    
    <h2>Login</h2>

    <!-- POST is used because login details should not appear in the URL. -->
    <!--Data is sent to loginprocess.php for validation. -->

    <form action="loginprocess.php" method="POST">

        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <!-- Password type hides characters for privacy -->
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">

    </form>

</body>
</html>