<?php
//start session
session_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <div class="header-container">

            <h1 class="webHeader"><img src="images/basketball.png" style="width:40px;height:20px;" /><a href= "index.php">StatSlam</a></h1>
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
        <main>
         <h2>Comments, Concerns, and Subscription Requests with StatSlam</h2>
            <h3>Contact Us</h3>
            <p>Submit a request using the form below or contact us directly at <a href="mailto:StatSlam@stats.com">StatSlam@stats.com</a></p>
            <p>Required fields are marked with an asterisk*.</p>
            <form method="post" action="https://formspree.io/f/mjkvljvg">
               <label for="First Name">*First Name:</label>
               <input type="text" id="First Name" name="First Name" required><br><br>

               <label for="Last Name">*Last Name:</label>
               <input type="text" id="Last Name" name="Last Name" required><br><br>

               <label for="Email">*E-mail Address:</label>
               <input type="email" id="Email" name="Email" required><br><br>

               <label for="Phone">Phone Number:</label>
               <input type="tel" id="Phone" name="Phone"><br><br>

               <label for="Subscription Package">Subscription Package:</label>
               <input type="text" id="Package" name="Package"><br><br>

               <label for="Comments">Comments and Requests:</label>
               <textarea id="Comments" name="Comments" rows="5" cols="25"></textarea><br><br>

               <input type="submit" id="Submit" value="Submit">
            </form>
      </main>
      <div>
    <footer>
      <Center>
          <br><br>Copyright &copy; 2024 StatSlam<br>
          <a href="mailto:StatSlam@stats.com">StatSlam@stats.com</a>
      </Center>
    </footer>
  </div>
    </body>

</html>
