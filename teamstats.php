<?php
session_start(); //start session
//if not loggedin then redirect to login
if (!isset($_SESSION["userID"])) {
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

$team = isset($_GET["team"]) ? $_GET["team"] : "";

$parts = preg_split('/\s+(?=\S*$)/', $team);

if ($team != "") {
    $stmt = $conn->prepare(
        "SELECT teamID FROM teaminfo WHERE city = ? AND name = ?"
    );
    $stmt->bind_param("ss", $parts[0], $parts[1]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $teamID = $row["teamID"];
    } else {
        die("Team not found.");
    }

    $stmt = $conn->prepare("SELECT * FROM teamtotals WHERE teamID = ?");
    $stmt->bind_param("i", $teamID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $teamTotals = $result->fetch_assoc();
    } else {
        die("error with team totals");
    }

    $stmt->close();
} else {
    die("Invalid team ID.");
}

if ($teamID >= 0) {
    $stmt = $conn->prepare("SELECT * FROM playerinfo WHERE teamID = ?");
    $stmt->bind_param("i", $teamID);
    $stmt->execute();
    $result = $stmt->get_result();

    $teamPlayers = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teamPlayers[] = $row;
        }
    } else {
        die("Player not found.");
    }

    $stmt->close();
} else {
    die("issue with players");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($team) ?> - Stats</title>
</head>
<body>
    <div class="header-container">
        <h1 class="webHeader">StatSlam</h1>
        <div class="search-container">
            <form action="search.php" method="post">
                <input type="text" class="search-input" name="search" placeholder="Search...">
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>

        <div class="topnav">
                      <a href="index.php">Home</a>
                      <a href="allPlayers.php">Players</a>
                      <a href="pricing.php">Pricing</a>

                      <?php if (!isset($_SESSION["userID"])): ?>
                          <!-- if logged in, show logout -->
                          <a href="login.php">Login</a>
                          <a href="signUp.php">Sign Up</a>
                      <?php else: ?>
                          <a href="logout.php">Logout</a>
                      <?php endif; ?>

                      <a href="contact.php">Contact</a>
                    </div>
    <div class="container">
        <h1><?= htmlspecialchars($team) ?> - Stats</h1>
        <p><strong>Games:</strong> <?= htmlspecialchars(
            $teamTotals["games"]
        ) ?></p>
        <p><strong>Points:</strong> <?= htmlspecialchars(
            $teamTotals["points"]
        ) ?></p>
        <p><strong>Field Goals Attempted:</strong> <?= htmlspecialchars(
            $teamTotals["fieldGoalsAttempted"]
        ) ?></p>
        <p><strong>Field Goals Made:</strong> <?= htmlspecialchars(
            $teamTotals["fieldGoalsMade"]
        ) ?></p>
        <p><strong>Field Goal Percentage:</strong> <?= htmlspecialchars(
            $teamTotals["fieldGoalPercentage"]
        ) ?></p>

        <p><strong>Two Pointers Attempted:</strong> <?= htmlspecialchars(
            $teamTotals["twoPointersAttempted"]
        ) ?></p>
        <p><strong>Two Pointers Made:</strong> <?= htmlspecialchars(
            $teamTotals["twoPointersMade"]
        ) ?></p>
        <p><strong>Two Pointer Percentage:</strong> <?= htmlspecialchars(
            $teamTotals["twoPointerPercentage"]
        ) ?></p>

        <p><strong>Three Pointers Attempted:</strong> <?= htmlspecialchars(
            $teamTotals["threePointersAttempted"]
        ) ?></p>
        <p><strong>Three Pointers Made:</strong> <?= htmlspecialchars(
            $teamTotals["threePointersMade"]
        ) ?></p>
        <p><strong>Three Pointer Percentage:</strong> <?= htmlspecialchars(
            $teamTotals["threePointerPercentage"]
        ) ?></p>

        <p><strong>Free Throws Attempted:</strong> <?= htmlspecialchars(
            $teamTotals["freeThrowsAttempted"]
        ) ?></p>
        <p><strong>Free Throws Made:</strong> <?= htmlspecialchars(
            $teamTotals["freeThrowsMade"]
        ) ?></p>
        <p><strong>Free Throw Percentage:</strong> <?= htmlspecialchars(
            $teamTotals["freeThrowPercentage"]
        ) ?></p>

        <p><strong>Offensive Rebounds:</strong> <?= htmlspecialchars(
            $teamTotals["offensiveRebounds"]
        ) ?></p>
        <p><strong>Defensive Rebounds:</strong> <?= htmlspecialchars(
            $teamTotals["defensiveRebounds"]
        ) ?></p>
        <p><strong>Assists:</strong> <?= htmlspecialchars(
            $teamTotals["assists"]
        ) ?></p>
        <p><strong>Blocks:</strong> <?= htmlspecialchars(
            $teamTotals["blocks"]
        ) ?></p>
    </div>
    <div class="container">
        <h1><?= htmlspecialchars($team) ?> - Players</h1>
        <?php if (!empty($teamPlayers)): ?>
            <ul>
                <?php foreach ($teamPlayers as $player): ?>
                    <li>
                        <a href="playerstats.php?playerID=<?= urlencode(
                            $player["playerID"]
                        ) ?>">
                            <?= htmlspecialchars($player["name"]) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No players found for this team.</p>
        <?php endif; ?>
    </div>
</body>
</html>
