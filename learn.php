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

// Get flashcards in set
$stmt = $conn->prepare("SELECT * FROM Flashcards WHERE SetID = ?");
$stmt->execute([$setid]);
$cards = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>

<title>Learn</title>

<style>

body{
    text-align:center;
    font-family:Arial;
}

/* flashcard box */
.card{
    width:400px;
    height:200px;
    border:2px solid black;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:40px auto;
    font-size:28px;
    cursor:pointer;
}

/* arrow buttons */
.arrow{
    font-size:40px;
    cursor:pointer;
    padding:20px;
}

.container{
    display:flex;
    justify-content:center;
    align-items:center;
}

</style>

</head>

<body>

<h2>Learn Flashcards</h2>

<div class="container">

<div class="arrow" onclick="prevCard()">◀</div>

<div class="card" id="flashcard" onclick="flipCard()">
    Loading...
</div>

<div class="arrow" onclick="nextCard()">▶</div>

</div>

<script>

// Flashcards from PHP
let cards = <?php echo json_encode($cards); ?>;

let index = 0;
let showingTerm = true;

// Display first card
showCard();

function showCard(){

    if(cards.length == 0){
        document.getElementById("flashcard").innerHTML = "No flashcards in ";
        return;
    }

    if(showingTerm){
        document.getElementById("flashcard").innerHTML = cards[index].Term;
    }else{
        document.getElementById("flashcard").innerHTML = cards[index].Definition;
    }
}

// Flip card
function flipCard(){
    showingTerm = !showingTerm;
    showCard();
}

// Next card
function nextCard(){
    if(cards.length == 0) return;
    // Move to next card, loop back to start if at the end
    index = (index + 1) % cards.length;
    // Always show term first when switching cards
    showingTerm = true;
    showCard();
}

// Previous card
function prevCard(){
    if(cards.length == 0) return;
    // Move to previous card, loop to last if at start
    index = (index - 1 + cards.length) % cards.length;
    showingTerm = true;
    showCard();
}

</script>

</body>
</html>