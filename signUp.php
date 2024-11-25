<!DOCTYPE html>

<html lang="en">
    <head>
        <div class="header-container">
            <h1 class="webHeader"><img src="basketball.png" style="width:40px;height:20px;" />StatSlam</h1>
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
            <h1>Create an Account</h1>
            <form method="POST" action="add_user.php">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required><br>

                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br>

                    <button type="submit">Sign Up</button>
                </form>
            <p>Already have an account? <a href="login.php">Log in here</a>.</p>
    </div>

</body>

</html>
