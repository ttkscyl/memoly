<?php
// Start session to ensure user is logged in
session_start();

if (!isset($_SESSION['CurrentUser'])) {
    header("Location: login.php");
    exit();
}

include_once("connection.php");

/*
    Get deck ID from URL.
    Example: learn.php?deck_id=1
*/
if (!isset($_GET['deck_id'])) {
    header("Location: sets.php");
    exit();
}

$deck_id = $_GET['deck_id'];

/*
    Security check:
    Ensure the deck belongs to the logged-in user.
*/
$check = $conn->prepare(
    "SELECT deck_id, title 
     FROM TblDecks 
     WHERE deck_id = :deck_id AND user_id = :user_id"
);
$check->bindParam(":deck_id", $deck_id);
$check->bindParam(":user_id", $_SESSION['CurrentUser']);
$check->execute();
$deck = $check->fetch(PDO::FETCH_ASSOC);

if (!$deck) {
    header("Location: sets.php");
    exit();
}

/*
    Retrieve flashcards for the selected deck.
*/
$stmt = $conn->prepare(
    "SELECT front, back 
     FROM TblCards 
     WHERE deck_id = :deck_id"
);
$stmt->bindParam(":deck_id", $deck_id);
$stmt->execute();
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Memoly | Learn Mode</title>

    <style>
        /* Container to center the card */
        .card-container {
            width: 300px;
            height: 200px;
            margin: 50px auto;
            perspective: 1000px;
        }

        /* Card itself */
        .card {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            cursor: pointer;
        }

        /* Flip the card */
        .card.flipped {
            transform: rotateY(180deg);
        }

        /* Front & back faces */
        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            padding: 10px;
            text-align: center;
            background-color: #f5f5f5;
        }

        .card-back {
            transform: rotateY(180deg);
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>

<h2 style="text-align:center;">
    Learn Mode: <?php echo htmlspecialchars($deck['title']); ?>
</h2>

<?php
if (count($cards) === 0) {
    echo "<p style='text-align:center;'>No flashcards in this set.</p>";
} else {
    // Show the first card only (simple learn mode)
    $first = $cards[0];
}
?>

<?php if (count($cards) > 0): ?>
    <div class="card-container">
        <div class="card" id="flashcard" onclick="flipCard()">
            <div class="card-face card-front">
                <?php echo htmlspecialchars($first['front']); ?>
            </div>
            <div class="card-face card-back">
                <?php echo htmlspecialchars($first['back']); ?>
            </div>
        </div>
    </div>

    <p style="text-align:center;">Click the card to flip</p>
<?php endif; ?>

<script>
    // Toggle the 'flipped' class to flip the card
    function flipCard() {
        document.getElementById("flashcard").classList.toggle("flipped");
    }
</script>

</body>
</html>

<?php
$conn = null;
?>