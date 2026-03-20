<?php
require_once "connection.php";
require_once "navbar.php";
session_start();  
?>

<!DOCTYPE html>
<html>
<head>

<title>Memoly</title>

<style>

body{
    text-align:center;
    font-family:Arial;
    margin-top:100px;
}

/* Container box */
.box{
    border:2px solid black;
    width:400px;
    margin:0 auto;
    padding:30px;
}

/* Buttons */
.button{
    display:inline-block;
    margin:15px;
    padding:10px 20px;
    border:2px solid black;
    text-decoration:none;
    color:black;
}

</style>

</head>

<body>

<div class="box">

<h2>Welcome to Memoly</h2>

<p>
Memoly is a flashcard learning website that allows users to create, organise, and study flashcards efficiently. 
Users can create sets, test their knowledge, and track their progress over time. Teachers can also create classes 
so that students can join and learn together.
</p>

<!-- Buttons -->
<a href="users.php" class="button">New User - Create Account</a>
<a href="login.php" class="button">Existing User - Log In</a>

</div>

</body>
</html>