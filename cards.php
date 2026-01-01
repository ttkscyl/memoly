<!-- Cards - Allows users to input details about their cards and post it to addcards -->
<!DOCTYPE html>
<html>
<head>
    <title>Create Cards</title>
</head>

<body>
    <!-- Create a form for the user to create a Flashcard -->
    <form action="addcards.php" method="post">
        Term:
        <input type="text" name="Term"><br>

        Definition:
        <input
            oninput="this.value = this.value.toUpperCase()"
            type="text"
            name="Definition"
        ><br>

        <!-- select set -->
        Set:
        <select name="Set"><br>
            <?php
            include_once("connection.php");

            $stmt = $conn->prepare("SELECT * FROM TblSets");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['SetID'] . "'>" . $row['SetName'] . "</option>";
            }
            ?>
        </select>
        <br>

        <input type="submit" value="Confirm">
    </form>

    <button onclick="history.back()">Go Back</button>
</body>
</html>
