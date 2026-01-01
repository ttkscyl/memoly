<!-- Login Page - to let users input their details and post them to the loginprocess -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- This ensures that empty fields cannot be sent through -->
    <script>
        function IsEmpty() {
            if (
                document.forms['loginform'].Username.value === "" ||
                document.forms['loginform'].password.value === ""
            ) {
                alert("empty");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <!-- Creates a form that lets user input username and password -->
    <form name="loginform" action="loginprocess.php" method="POST">
        User name:
        <input type="text" name="Username"><br>

        Password:
        <input type="password" name="password"><br>

        <input onclick="return IsEmpty();" type="submit" value="Login">
    </form>

    <!-- Redirects the user to a page where they create their account -->
    <a href="users.php">Sign up</a>
</body>
</html>
