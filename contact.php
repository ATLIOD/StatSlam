<?php
//start session
session_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <div class="header-container">

            <h1 class="webHeader"><img src="images/basketball.png" style="width:40px;height:20px;" />StatSlam</h1>
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
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>


        <div class="topnav">
                      <a href="index.php">Home</a>
                      <a href="allPlayers.php">Players</a>
                      <a href="pricing.php">Pricing</a>


                    <?php if (!isset($_SESSION["userID"])): ?>
                        <a href="login.php">Login</a>
                        <a href="signUp.php">Sign Up</a>
                    <?php else: ?>
                        <a href="logout.php">Logout</a>
                    <?php endif; ?>


                      <a class = "active" href="contact.php">Contact</a>
                    </div>


</html>
