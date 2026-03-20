<?php
require_once "connection.php";
require_once "navbar.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Check set selected
if (!isset($_GET['setid'])) {
    echo "No set selected.";
    exit();
}

$setid = $_GET['setid'];

// Get flashcards from this set
$stmt = $conn->prepare("SELECT * FROM Flashcards WHERE SetID = ?");
$stmt->execute([$setid]);
$cards = $stmt->fetchAll();

// Store cards in session so we can reuse them
$_SESSION['test_cards'] = $cards;

// Pick random card index
$randomIndex = rand(0, count($cards) - 1);
$_SESSION['current_index'] = $randomIndex;

$currentCard = $cards[$randomIndex];

$message = "";

// If user submitted answer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userAnswer = $_POST['answer'];
    $correctAnswer = $_POST['correct'];

if (strtolower(trim($userAnswer)) == strtolower(trim($correctAnswer))) {
    $message = "Correct!";
} else {
    $message = "Incorrect. Correct answer: " . $correctAnswer;
}

    // Pick new random card
    $randomIndex = rand(0, count($cards) - 1);
    $_SESSION['current_index'] = $randomIndex;
    $currentCard = $cards[$randomIndex];
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Test</title>

<style>

body{
    text-align:center;
    font-family:Arial;
}

/* Term box */
.term{
    border:2px solid black;
    width:200px;
    margin:40px auto;
    padding:20px;
    font-size:24px;
}

/* Input box */
input{
    width:400px;
    padding:10px;
    margin:20px;
}

button{
    padding:10px 30px;
}

</style>

</head>

<body>

<h2>Test Mode</h2>

<!-- Display term -->
<div class="term">
    <?php echo $currentCard['Term']; ?>
</div>

<!-- Form -->
<form method="POST">

    <input type="text" name="answer" placeholder="Your answer" required>

    <!-- Hidden correct answer -->
    <input type="hidden" name="correct" value="<?php echo $currentCard['Definition']; ?>">

    <br>

    <button type="submit">Confirm</button>

</form>

<!-- Show result -->
<p><?php echo $message; ?></p>

</body>
</html>