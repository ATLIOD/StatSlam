<?php
//start session
session_start();
//check if session logged in, if not then redirect to login
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit();
}
$host = "localhost";
$username = "root";
$password = "";
$database = "statslam_db";
//connect to database
$conn = new mysqli($host, $username, $password, $database);
//if connection fail then error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// get player id from url
$playerID = isset($_GET["playerID"]) ? intval($_GET["playerID"]) : -1;
// if player id valid
if ($playerID >= 0) {
    //query dtabase for statc matching playerid
    $stmt = $conn->prepare("SELECT * FROM playertotals WHERE playerID = ?");
    $stmt->bind_param("i", $playerID); //bind player id to ? for the query
    $stmt->execute(); // execute query
    $result = $stmt->get_result();
    // if result exists
    if ($result->num_rows > 0) {
        $playerTotals = $result->fetch_assoc(); //store results
    } else {
        //else error
        die("error with player totals");
    }

    $stmt->close();
} else {
    die("Invalid player ID.");
}

if ($playerID >= 0) {
    // queary playerinfo for data relating to playerid
    $stmt = $conn->prepare(
        "SELECT name,age,seasonsPlayed,position,teamID FROM playerinfo WHERE playerID = ?"
    );
    $stmt->bind_param("i", $playerID); //gind playerid to ?
    $stmt->execute();
    $result = $stmt->get_result();

    //if result exist
    if ($result->num_rows > 0) {
        $playerInfo = $result->fetch_assoc(); //store result
    } else {
        die("error with player info");
    }

    $stmt->close();
} else {
    die("issue with players");
}

//query team info for team naem relating to team id that matched player id
$stmt = $conn->prepare("SELECT city, name FROM teaminfo WHERE teamID = ?");
$stmt->bind_param("i", $playerInfo["teamID"]); //bind teamid to ?
$stmt->execute();
$result = $stmt->get_result();

//if exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teamName = $row["city"] . " " . $row["name"]; //concatenate strings and store
} else {
    die("Team not found.");
}

$conn->close();
?>


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
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($playerInfo["name"]) ?> - Info</title>
</head>
<body>


    <div class="topnav">
              <a href="index.php">Home</a>
              <a href="allPlayers.php">Players</a>
              <a href="pricing.php">Pricing</a>

              <?php if (!isset($_SESSION["userID"])): ?>
                  <!-- if logged in then show logout -->
                  <a href="login.php">Login</a>
                  <a href="signUp.php">Sign Up</a>
              <?php else: ?>
                  <a href="logout.php">Logout</a>
              <?php endif; ?>

              <a href="contact.php">Contact</a>
            </div>


    <div class="container">
        <h1><?= htmlspecialchars($playerInfo["name"]) ?> - info</h1>
        <?php if (!empty($playerInfo)): ?>
            <ul>
                <p><strong>age:</strong> <?= htmlspecialchars(
                    $playerInfo["age"]
                ) ?></p>
                <p><strong>seasons:</strong> <?= htmlspecialchars(
                    $playerInfo["seasonsPlayed"]
                ) ?></p>
                <p><strong>Position:</strong> <?= htmlspecialchars(
                    $playerInfo["position"]
                ) ?></p>
                <p><strong>Team:</strong> <?= htmlspecialchars($teamName) ?></p>
            </ul>
    <div class="container">
        <h1><?= htmlspecialchars($playerInfo["name"]) ?> - Stats</h1>
        <p><strong>Points:</strong> <?= htmlspecialchars(
            $playerTotals["points"]
        ) ?></p>
        <p><strong>Field Goals Attempted:</strong> <?= htmlspecialchars(
            $playerTotals["fieldGoalsAttempted"]
        ) ?></p>
        <p><strong>Field Goals Made:</strong> <?= htmlspecialchars(
            $playerTotals["fieldGoalsMade"]
        ) ?></p>
        <p><strong>Field Goal Percentage:</strong> <?= htmlspecialchars(
            $playerTotals["fieldGoalPercentage"]
        ) ?></p>

        <p><strong>Two Pointers Attempted:</strong> <?= htmlspecialchars(
            $playerTotals["twoPointersAttempted"]
        ) ?></p>
        <p><strong>Two Pointers Made:</strong> <?= htmlspecialchars(
            $playerTotals["twoPointersMade"]
        ) ?></p>
        <p><strong>Two Pointer Percentage:</strong> <?= htmlspecialchars(
            $playerTotals["twoPointerPercentage"]
        ) ?></p>

        <p><strong>Three Pointers Attempted:</strong> <?= htmlspecialchars(
            $playerTotals["threePointersAttempted"]
        ) ?></p>
        <p><strong>Three Pointers Made:</strong> <?= htmlspecialchars(
            $playerTotals["threePointersMade"]
        ) ?></p>
        <p><strong>Three Pointer Percentage:</strong> <?= htmlspecialchars(
            $playerTotals["threePointerPercentage"]
        ) ?></p>

        <p><strong>Free Throws Attempted:</strong> <?= htmlspecialchars(
            $playerTotals["freeThrowsAttempted"]
        ) ?></p>
        <p><strong>Free Throws Made:</strong> <?= htmlspecialchars(
            $playerTotals["freeThrowsMade"]
        ) ?></p>
        <p><strong>Free Throw Percentage:</strong> <?= htmlspecialchars(
            $playerTotals["freeThrowPercentage"]
        ) ?></p>

        <p><strong>Offensive Rebounds:</strong> <?= htmlspecialchars(
            $playerTotals["offensiveRebounds"]
        ) ?></p>
        <p><strong>Defensive Rebounds:</strong> <?= htmlspecialchars(
            $playerTotals["defensiveRebounds"]
        ) ?></p>
        <p><strong>Assists:</strong> <?= htmlspecialchars(
            $playerTotals["assists"]
        ) ?></p>
        <p><strong>Blocks:</strong> <?= htmlspecialchars(
            $playerTotals["blocks"]
        ) ?></p>
    </div>
            <?php else: ?>
            <p>No players found for this team.</p>
        <?php endif; ?>
    </div>
</body>
</html>
