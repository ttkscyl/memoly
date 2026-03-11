<?php
session_start(); // Start session so we can check login status
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memoly</title>
    <link rel="stylesheet" href="style.css">

    <!-- Oxanium font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&display=swap" rel="stylesheet">

    <!-- BS5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.php">
                <img src="mypictures/icon.jpg" alt="company logo" style="width:45px;" class="rounded-pill">
                <span><b>&nbsp;&nbsp; Memoly</b></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Center nav links -->
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="library.php">Library</a></li>
                    <li class="nav-item"><a class="nav-link" href="class.php">Class</a></li>
                    <li class="nav-item"><a class="nav-link" href="folders.php">New Folder</a></li>
                    <li class="nav-item"><a class="nav-link" href="sets.php">New Set</a></li>
                </ul>
            </div>

            <!-- Right side -->
            <div class="d-flex align-items-center" id="user-section">

                <?php if (isset($_SESSION['UserID'])) { ?>

                    <!-- If user is logged in show logout -->
                    <a href="logout.php" class="nav-link">Logout</a>

                <?php } else { ?>

                    <!-- If user is not logged in show login -->
                    <a href="login.php" class="nav-link">Login</a>

                <?php } ?>

            </div>

        </div>
    </nav>

    <br>

</body>
</html>