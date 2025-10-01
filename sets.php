<!-- sets.php -->
<?php
session_start();
if (!isset($_SESSION["CurrentUser"])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Set</title>
    <script>
        function IsEmpty() {
            if (document.forms['createset']['SetName'].value.trim() === "") {
                alert("Set Name cannot be empty");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <!-- Create a form for the user to create a set -->
    <form name="createset" action="addset.php" method="post">
        Name: <input type="text" name="SetName"><br>
        Description: <input type="text" name="SetDescription"><br>

        <!-- selecting the status of the set -->
        <input type="radio" name="status" value="Public" checked> Public<br>
        <input type="radio" name="status" value="Private"> Private<br>

        <input onclick="return IsEmpty();" type="submit" value="Confirm">
    </form>

    <button onclick="history.back()">Go Back</button>
</body>

</html>