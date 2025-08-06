<!-- Login Page lets users input their details and post them to the loginprocess -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script>
        function IsEmpty() {
            if (document.forms['loginform'].Username.value === "" || 
                document.forms['loginform'].password.value === "") {
                alert("Please fill in all fields.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <h2>Login</h2>

    <!-- Show error messages -->
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] === "invalidpassword") {
            echo "<p style='color:red;'>Incorrect password.</p>";
        } elseif ($_GET['error'] === "usernotfound") {
            echo "<p style='color:red;'>Username not found.</p>";
        }
    }
    ?>

    <form name='loginform' action="loginprocess.php" method="POST">
        Username: <input type="text" name="Username"><br>
        Password: <input type="password" name="password"><br>
        <input onclick="return IsEmpty();" type="submit" value="Login">
    </form>

    <br>
    <a href="users.php">Register</a>
</body>
</html>