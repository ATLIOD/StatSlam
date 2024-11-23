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
        <link rel="stylesheet" href="sign-up.css">
        <link rel="stylesheet" href="index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>


        <div class="topnav">
                  <a href="index.php">Home</a>
                  <a href="allPlayers.php">Players</a>
                  <a href="pricing.php">Pricing</a>
                  <a href="login.php">Login</a>
                  <a class="active" href="signUp.php">Sign Up</a>
                  <a href="contact.php">Contact</a>
                </div>

    <div class="signup">
        <tr>
        <center>
            <h2>Sign up</h2>
        </center>
        </tr>
        <form>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="text" id="password" name="password"><br>
        <label for="confirmPassword">Confirm Password:</label><br>
        <input type="text" id="confirmPassword" name="confirmPassword">

        </form>
    </div>
    <div>
        <button class="signUpSubmit" type="button">Submit
        </button>
    </div>

</body>

</html>
