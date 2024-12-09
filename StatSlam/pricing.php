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
            <h1 class="webHeader"><img src="images/basketball.png" style="width:40px;height:20px;" /><a href= "index.php">StatSlam</a></h1>
            <div class="search-container">
                <form action="search.php" method="post">
                    <input type="text" class="search-input" name="search" placeholder="Search...">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>
        </div>
        <title>
            StatSlam
        </title>
        <link rel="stylesheet" href="css/index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <div class="topnav">
                      <a href="index.php">Home</a>
                      <a href="allPlayers.php">Players</a>
                      <a class = "active" href="pricing.php">Pricing</a>

                      <?php if (!isset($_SESSION["userID"])): ?>
                          <a href="login.php">Login</a>
                          <a href="signUp.php">Sign Up</a>
                      <?php else: ?>
                          <a href="logout.php">Logout</a>
                      <?php endif; ?>

                      <a href="contact.php">Contact</a>
                    </div>

    <div>
    <main>
         <h2>Subscription Packages with StatSlam</h2>
         <p>A variety of subscription packages are available with StatSlam! Find the one best for you and put in a subscription request using the form in the Contact page. We appreciate your business and hope you enjoy our services! </p>
         <table>
            <tr>
               <th>Package Name</th>
               <th>Description</th>
               <th>Average Cost</th>
            </tr>
            <tr>
               <td>Basic Package</td>
               <td class="text">Access to all player and team stats</td>
               <td>$5.99/month</td>
            </tr>
            <tr>
               <td>Premium Package</td>
               <td class="text">Access to all player and team stats, stat comparisons, live updates, unlimited searches, customizable interface</td>
               <td>$9.99/month</td>
            </tr>
         </table>
      </main>
    </div>
        
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
