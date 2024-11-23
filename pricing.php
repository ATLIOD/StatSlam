<?php
session_start();
if (!isset($_SESSION["userID"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <div class="header-container">
            <h1 class="webHeader">StatSlam</h1>
            <div class="search-container">
                <form action="search.php" method="post">
                    <input type="text" class="search-input" name="search" placeholder="Search...">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>
        </div>
        <title>
            Stats site
        </title>
        <link rel="stylesheet" href="index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <div class="topnav">
                      <a href="index.php">Home</a>
                      <a href="allPlayers.php">Players</a>
                      <a class = "active" href="pricing.php">Pricing</a>

                      <?php if (!isset($_SESSION["userID"])): ?>
                          <!-- Only show Login and Sign Up if the user is not logged in -->
                          <a href="login.php">Login</a>
                          <a href="signUp.php">Sign Up</a>
                      <?php else: ?>
                          <!-- Show Logout when logged in -->
                          <a href="logout.php">Logout</a>
                      <?php endif; ?>

                      <a href="contact.php">Contact</a>
                    </div>

    <div>
        <div>
            <h1 >Coming Soon!</h1>
        </div>
    </body>
</html>
