<!-- Users - Allows users to input their details and post them to addusers -->
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>

<body>
    <!-- Creates a form for the user to sign up -->
    <form action="addusers.php" method="post">
        Email:
        <input type="text" name="Email"><br>

        Username:
        <input type="text" name="Username"><br>

        Password:
        <input type="password" name="password"><br>

        <br>
        <input type="submit" value="Confirm">
    </form>

    <!-- directs users to login page -->
    <a href="login.php">Sign up</a>
</body>
</html>
