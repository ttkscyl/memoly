<!DOCTYPE html>
<html>

<head>
    <title>Memoly | Sign up</title>
</head>

<body>

    <h1>Sign up</h1>

    <!-- Display feedback messages from addusers.php -->
    <?php
    if (isset($_GET['success'])) {
        echo "<p style='color:green;'>Account created successfully. You can now log in.</p>";
    } elseif (isset($_GET['error'])) {
        echo "<p style='color:red;'>An error occurred. Please try again.</p>";
    }
    ?>

    <!-- Registration form -->
    <form action="addusers.php" method="post">

        <!-- Input name -->
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <!-- Input username -->
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <!-- Input email address -->
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <!-- Input password -->
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <!-- Checkbox to determine if the user is a teacher -->
        <label for="is_teacher">Are you a teacher?</label><br>
        <input type="checkbox" id="is_teacher" name="is_teacher"><br><br>

        <input type="submit" value="Sign Up">
    </form>

</body>
</html>