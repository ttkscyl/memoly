<!DOCTYPE html>
<html>
    <head>
        <title>Sign up</title>
    </head>

    <body>
        <h1>Sign up</h1>
        <form action="addusers.php" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br>

            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>

            <label for="is_teacher">Are you a teacher?</label><br>
            <input type="checkbox" id="is_teacher" name="is_teacher"><br><br>
            <input type="submit" value="Sign Up">
        </form>
    </body>
</html>