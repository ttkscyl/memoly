<!-- Login Page lets users input their details and post them to the loginprocess -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- JavaScript function to validate that both input fields are filled before submitting the form -->
    <script>
        function IsEmpty() {
            if (document.forms['loginform'].Username.value === "" || 
                document.forms['loginform'].password.value === "") {
                alert("Please fill in all fields.");
                return false; // Prevent form submission if fields are empty
            }
            return true; // Allow form submission if both fields are filled
        }
    </script>
</head>

<body>
    <h2>Login</h2>

    <!-- PHP code to show error messages from the server -->
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] === "invalidpassword") {
            echo "<p style='color:red;'>Incorrect password.</p>";
        } elseif ($_GET['error'] === "usernotfound") {
            echo "<p style='color:red;'>Username not found.</p>";
        }
    }
    ?>

    <!-- Login form -->
    <form name='loginform' action="loginprocess.php" method="POST">
        Username: <input type="text" name="Username"><br>
        Password: <input type="password" name="password"><br>
        <input onclick="return IsEmpty();" type="submit" value="Login">
    </form>

    <br>
    <a href="users.php">Register</a>
</body>
</html>