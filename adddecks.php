<?php
session_start();

try {
    include_once('connection.php');

    // Determine topic (optional)
    $topicId = !empty($_POST["TopicID"]) ? $_POST["TopicID"] : null;

    // Insert new deck into TblDecks
    $stmt = $conn->prepare("
        INSERT INTO TblDecks (user_id, title, description, topic_id) 
        VALUES (:user_id, :title, :description, :topic_id)
    ");
    $stmt->bindParam(':user_id', $_SESSION['CurrentUser']);
    $stmt->bindParam(':title', $_POST["DeckName"]);
    $stmt->bindParam(':description', $_POST["DeckDescription"]);
    $stmt->bindParam(':topic_id', $topicId);

    $stmt->execute();

    // Redirect to decks list page
    header("Location: decks.php?success=1");
    exit;

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}

$conn = null;
?>