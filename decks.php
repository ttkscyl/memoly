<?php
session_start();
if (!isset($_SESSION["CurrentUser"])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Memoly | Create decks</title>
    <script>
        function IsEmpty() {
            if (document.forms['createset']['DeckName'].value.trim() === "") {
                alert("Deck Name cannot be empty");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <!-- Create a form for the user to create a deck -->
    <form name="createset" action="adddecks.php" method="post">
        Name: <input type="text" name="DeckName"><br>
        Description: <input type="text" name="DeckDescription"><br>

        <!-- selecting the status of the set -->
        <input type="radio" name="status" value="Public" checked> Public<br>
        <input type="radio" name="status" value="Private"> Private<br>

        <input onclick="return IsEmpty();" type="submit" value="Confirm">
    </form>

    <button onclick="history.back()">Go Back</button>
</body>
</html>