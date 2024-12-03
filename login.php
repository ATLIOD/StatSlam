<?php
//start session
session_start(); ?>
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
        <link rel="stylesheet" href="login.css">
        <link rel="stylesheet" href="index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <div class="topnav">
          <a href="index.php">Home</a>
          <a href="allPlayers.php">Players</a>
          <a href="pricing.php">Pricing</a>
          <a class="active" href="login.php">Login</a>
          <a href="signUp.php">Sign Up</a>
          <a href="contact.php">Contact</a>
        </div>

    <div class="login">
        <tr>
        <center>
            <h2>Login</h2>
        </center>
        </tr>
        <form method="POST" action="login_user.php">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>
        <p>Need to make an account? <a href="signUp.php">Sign up here</a>.</p>
    </div>
    </body>
</html>
