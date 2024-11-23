<?php
session_start();
if (!isset($_SESSION["userID"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
$host = "localhost";
$username = "root";
$password = "";
$database = "statslam_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$playerID = isset($_GET["playerID"]) ? intval($_GET["playerID"]) : -1;

if ($playerID >= 0) {
    $stmt = $conn->prepare("SELECT * FROM playertotals WHERE playerID = ?");
    $stmt->bind_param("i", $playerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $playerTotals = $result->fetch_assoc();
    } else {
        die("error with player totals");
    }

    $stmt->close();
} else {
    die("Invalid player ID.");
}

if ($playerID >= 0) {
    $stmt = $conn->prepare(
        "SELECT name,age,seasonsPlayed,position,teamID FROM playerinfo WHERE playerID = ?"
    );
    $stmt->bind_param("i", $playerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $playerInfo = $result->fetch_assoc();
    } else {
        die("error with player info");
    }

    $stmt->close();
} else {
    die("issue with players");
}

$stmt = $conn->prepare("SELECT city, name FROM teaminfo WHERE teamID = ?");
$stmt->bind_param("i", $playerInfo["teamID"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teamName = $row["city"] . " " . $row["name"];
} else {
    die("Team not found.");
}

$conn->close();
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
                  <!-- Only show Login and Sign Up if the user is not logged in -->
                  <a href="login.php">Login</a>
                  <a href="signUp.php">Sign Up</a>
              <?php else: ?>
                  <!-- Show Logout when logged in -->
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
