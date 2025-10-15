<?php
session_start();
if(isset($_SESSION['CurrentUser'])) // checks if user is currently logged in 
{
    unset($_SESSION['CurrentUser']); // reset session variable
}
header('location: login.php') // redirects to login page
?>