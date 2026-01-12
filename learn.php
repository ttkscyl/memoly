<?php include_once("navbar.php"); ?>

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
if (!isset($_GET['deck_id']) || !ctype_digit($_GET['deck_id'])) {
    header("Location: sets.php");
    exit();
}

$deck_id = (int)$_GET['deck_id'];

/*
    Security check:
    Ensure the deck belongs to the logged-in user.
*/
$check = $conn->prepare(
    "SELECT deck_id, title 
     FROM TblDecks 
     WHERE deck_id = :deck_id AND user_id = :user_id"
);
$check->bindParam(":deck_id", $deck_id, PDO::PARAM_INT);
$check->bindParam(":user_id", $_SESSION['CurrentUser'], PDO::PARAM_INT);
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
$stmt->bindParam(":deck_id", $deck_id, PDO::PARAM_INT);
$stmt->execute();
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count cards
$total = count($cards);

// If no cards, display message later
if ($total > 0) {
    /*
        Get card index from URL. Default to 0 (first card).
        Clamp the index so it stays within valid range.
    */
    $index = (isset($_GET['index']) && ctype_digit($_GET['index'])) ? (int)$_GET['index'] : 0;

    if ($index < 0) $index = 0;
    if ($index > $total - 1) $index = $total - 1;

    $current = $cards[$index];
}
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
            margin: 30px auto 10px auto;
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

        /* Buttons area */
        .nav-buttons {
            text-align: center;
            margin-top: 10px;
        }

        .nav-buttons a {
            display: inline-block;
            padding: 8px 14px;
            margin: 0 6px;
            border: 1px solid #333;
            text-decoration: none;
            color: black;
            background: #f5f5f5;
        }

        .progress {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<h2 style="text-align:center;">
    Learn Mode: <?php echo htmlspecialchars($deck['title']); ?>
</h2>

<?php if ($total === 0): ?>
    <p style="text-align:center;">No flashcards in this set.</p>

<?php else: ?>

    <!-- Progress text -->
    <p class="progress">
        Card <?php echo $index + 1; ?> of <?php echo $total; ?>
    </p>

    <!-- Flashcard -->
    <div class="card-container">
        <div class="card" id="flashcard" onclick="flipCard()">
            <div class="card-face card-front">
                <?php echo htmlspecialchars($current['front']); ?>
            </div>
            <div class="card-face card-back">
                <?php echo htmlspecialchars($current['back']); ?>
            </div>
        </div>
    </div>

    <p style="text-align:center;">Click the card to flip</p>

    <!-- Navigation buttons -->
    <div class="nav-buttons">
        <?php if ($index > 0): ?>
            <a href="learn.php?deck_id=<?php echo $deck_id; ?>&index=<?php echo $index - 1; ?>" onclick="resetFlip()">
                Previous
            </a>
        <?php endif; ?>

        <?php if ($index < $total - 1): ?>
            <a href="learn.php?deck_id=<?php echo $deck_id; ?>&index=<?php echo $index + 1; ?>" onclick="resetFlip()">
                Next
            </a>
        <?php endif; ?>
    </div>

<?php endif; ?>

<script>
    // Toggle the 'flipped' class to flip the card
    function flipCard() {
        document.getElementById("flashcard").classList.toggle("flipped");
    }

    // Ensure the card is not flipped when moving to another card
    function resetFlip() {
        var card = document.getElementById("flashcard");
        if (card) {
            card.classList.remove("flipped");
        }
    }
</script>

</body>
</html>

<?php
$conn = null;
?>