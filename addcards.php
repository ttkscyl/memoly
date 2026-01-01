<?php
// addcards - insert the posted value into the corresponding table
header("Location: cards.php");

try {
    include_once("connection.php");
    array_map("htmlspecialchars", $_POST);

    print_r($_POST);

    // insert Card detail into Card table
    $stmt = $conn->prepare("
        INSERT INTO TblCards (CardID, Term, Definition)
        VALUES (NULL, :Term, :Definition)
    ");
    $stmt->bindParam(':Term', $_POST['Term']);
    $stmt->bindParam(':Definition', $_POST['Definition']);
    $stmt->execute();

    // find last created entry
    $stmt1 = $conn->prepare("
        SELECT CardID FROM TblCards WHERE CardID = LAST_INSERT_ID()
    ");
    $stmt1->execute();

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $currentCard = $row['CardID'];
    }

    echo $currentCard;

    // link CardID with its set
    $stmt3 = $conn->prepare("
        INSERT INTO TblSetContent (SetID, CardID)
        VALUES (:SetID, :CardID)
    ");
    $stmt3->bindParam(':SetID', $_POST['Set']);
    $stmt3->bindParam(':CardID', $currentCard);
    $stmt3->execute();

} catch (PDOException $e) {
    echo "error" . $e->getMessage();
}

$conn = null;
?>
