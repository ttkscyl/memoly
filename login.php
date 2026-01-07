<!DOCTYPE html>
<html>

<head>
    <title>Memoly | Login</title>

    <!-- 
        Client-side validation to ensure both fields are filled in
        before the form is submitted. This improves usability and
        reduces unnecessary server requests.
    -->
    <script>
        function IsEmpty() {
            // Check if either the username or password field is empty
            if (document.forms['loginform'].Username.value === "" ||
                document.forms['loginform'].password.value === "") {
                alert("Please fill in all fields.");
                return false; // Stop form submission
            }
            return true; // Allow form submission
        }
    </script>
</head>

<body>

    <h2>Login</h2>

    <?php
    /*
        Display error messages passed from loginprocess.php using
        the URL parameter 'error'. This provides clear feedback
        to the user about why login failed.
    */
    if (isset($_GET['error'])) {
        if ($_GET['error'] === "invalidpassword") {
            echo "<p style='color:red;'>Incorrect password.</p>";
        } elseif ($_GET['error'] === "usernotfound") {
            echo "<p style='color:red;'>Username not found.</p>";
        } elseif ($_GET['error'] === "emptyfields") {
            echo "<p style='color:red;'>Please fill in all fields.</p>";
        }
    }
    ?>

    <!-- 
        Login form submits data securely using POST.
        Data is sent to loginprocess.php for server-side validation.
    -->
    <form name="loginform" action="loginprocess.php" method="POST">
        Username: <input type="text" name="Username"><br>
        Password: <input type="password" name="password"><br>

        <!-- 
            The onclick attribute runs the JavaScript validation
            before allowing the form to submit.
        -->
        <input onclick="return IsEmpty();" type="submit" value="Login">
    </form>

    <br>

    <!-- Link to registration page for new users -->
    <a href="users.php">Register Here</a>

</body>
</html>
