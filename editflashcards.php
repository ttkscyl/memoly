<?php
require_once "connection.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.html");
    exit();
}

// Get the selected set
if (!isset($_GET['setid'])) {
    echo "No set selected.";
    exit();
}

$setid = $_GET['setid'];

// Retrieve flashcards belonging to this set
$stmt = $conn->prepare("SELECT * FROM Flashcards WHERE SetID = ?");
$stmt->execute([$setid]);
$flashcards = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Flashcards</title>

<style>

body{
    text-align:center;
    font-family:Arial;
}

/* Flashcard row layout */
.card-row{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:20px;
    margin:20px;
}

.box{
    border:2px solid black;
    padding:15px;
    width:200px;
}

input{
    width:90%;
}

button{
    padding:8px 15px;
}

.add-button{
    margin-top:40px;
    padding:15px 40px;
}

</style>

</head>

<body>

<h2>Edit Flashcards</h2>

<?php
$number = 1;

// Loop through all flashcards
foreach ($flashcards as $card) {
?>

<div class="card-row">

    <!-- Flashcard number -->
    <?php echo $number; ?>

    <!-- Term -->
    <div class="box">
        <p>Term</p>
        <?php echo htmlspecialchars($card['Term']); ?>
    </div>

    <!-- Definition -->
    <div class="box">
        <p>Definition</p>
        <?php echo htmlspecialchars($card['Definition']); ?>
    </div>

    <!-- Delete button -->
    <form action="deleteflashcards.php" method="POST">
        <input type="hidden" name="cardid" value="<?php echo $card['CardID']; ?>">
        <input type="hidden" name="setid" value="<?php echo $setid; ?>">
        <button type="submit">Delete</button>
    </form>

</div>

<?php
$number++;
}
?>

<!-- Form to add new flashcard -->

<h3>Add Flashcard</h3>

<form action="addflashcard.php" method="POST">

<input type="hidden" name="setid" value="<?php echo $setid; ?>">

<div class="card-row">

<div class="box">
<p>Term</p>
<input type="text" name="term" required>
</div>

<div class="box">
<p>Definition</p>
<input type="text" name="definition" required>
</div>

<button type="submit">Add</button>

</div>

</form>

</body>
</html>