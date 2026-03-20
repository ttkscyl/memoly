<?php
require_once "connection.php";
require_once "navbar.php";
session_start();  

// Ensure user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['UserID'];
$isTeacher = $_SESSION['IsTeacher'];  // 1 = teacher, 0 = student

$message = "";

/* Teacher create class */
if (isset($_POST['create'])) {

    // Insert new class linked to teacher
    $stmt = $conn->prepare("INSERT INTO Classes (TeacherID) VALUES (?)");
    $stmt->execute([$userid]);

    // Get the auto-generated ClassID (used as class code)
    $classID = $conn->lastInsertId();

    $message = "Class created. Class Code: " . $classID;
}

/* Students join class */
if (isset($_POST['join'])) {

    $classID = $_POST['classid'];

    // Check if class exists
    $stmt = $conn->prepare("SELECT * FROM Classes WHERE ClassID = ?");
    $stmt->execute([$classID]);
    $class = $stmt->fetch();

    if ($class) {

        // Add student to class
        $stmt = $conn->prepare("INSERT INTO UserInClass (UserID, ClassID) VALUES (?, ?)");
        $stmt->execute([$userid, $classID]);

        $message = "Joined class successfully.";
    } else {
        $message = "Class does not exist.";
    }
}

/* Class user is in */
$stmt = $conn->prepare("
    SELECT Classes.ClassID 
    FROM Classes
    JOIN UserInClass ON Classes.ClassID = UserInClass.ClassID
    WHERE UserInClass.UserID = ?
");
$stmt->execute([$userid]);
$userClasses = $stmt->fetchAll();

/* Class teacher created */
$teacherClasses = [];

if ($isTeacher) {
    $stmt = $conn->prepare("SELECT * FROM Classes WHERE TeacherID = ?");
    $stmt->execute([$userid]);
    $teacherClasses = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Class Page</title>

<style>

body{
    text-align:center;
    font-family:Arial;
}

.box{
    border:2px solid black;
    width:300px;
    margin:20px auto;
    padding:20px;
}

input{
    width:90%;
    margin:10px;
}

button{
    padding:10px 20px;
}

</style>

</head>

<body>

<h2>Class Page</h2>

<!-- Display message -->
<p><?php echo $message; ?></p>

<?php if ($isTeacher) { ?>

<!-- Teacher view -->

<div class="box">

<h3>Create Class</h3>

<form method="POST">

<input type="text" name="classname" placeholder="Class Name (optional)"><br>

<button type="submit" name="create">Create</button>

</form>

</div>

<?php } else { ?>

<!-- Student view -->

<div class="box">

<h3>Join Class</h3>

<form method="POST">

<input type="number" name="classid" placeholder="Enter Class Code" required><br>

<button type="submit" name="join">Join</button>

</form>

</div>

<?php } ?>


<!-- User's class -->

<h3>Your Classes</h3>

<?php if (count($userClasses) > 0) { ?>

<?php foreach ($userClasses as $c) { ?>

<div class="box">
    <p>Class Code: <?php echo $c['ClassID']; ?></p>
</div>

<?php } ?>

<?php } else { ?>

<p>You are not in any classes.</p>

<?php } ?>


<!-- View students as teacher -->

<?php if ($isTeacher) { ?>

<h3>Your Created Classes</h3>

<?php foreach ($teacherClasses as $class) { ?>

<div class="box">

<p><b>Class Code:</b> <?php echo $class['ClassID']; ?></p>

<?php
// Get students in this class
$stmt = $conn->prepare("
    SELECT Users.Username 
    FROM Users
    JOIN UserInClass ON Users.UserID = UserInClass.UserID
    WHERE UserInClass.ClassID = ?
");
$stmt->execute([$class['ClassID']]);
$students = $stmt->fetchAll();
?>

<p><b>Students:</b></p>

<?php if (count($students) > 0) { ?>

<?php foreach ($students as $s) { ?>
    <p><?php echo $s['Username']; ?></p>
<?php } ?>

<?php } else { ?>

<p>No students yet.</p>

<?php } ?>

</div>

<?php } ?>

<?php } ?>

</body>
</html>