<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "statslam_db";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get player_id from URL
$fullName = isset($_GET["fullName"]) ? intval($_GET["fullName"]) : "";

$parts = preg_split('/\s+(?=\S*$)/', $fullName);

if ($fullName != "") {
    // Query player data
    $stmt = $conn->prepare(
        "SELECT teamID FROM teaminfo WHERE city = ? AND name = ?"
    );
    $stmt->bind_param("ss", $parts[0], $parts[1]);
    $stmt->execute();
    $teamID = $stmt->get_result();

    $stmt = $conn->prepare("SELECT * FROM teamtotals WHERE teamID = ?");
    $stmt->bind_param("i", $teamID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $teamTotals = $result->fetch_assoc();
    } else {
        die("Player not found.");
    }

    $stmt->close();
} else {
    die("Invalid team ID.");
}

if ($fullName != "") {
    // Query player data
    $stmt = $conn->prepare("SELECT * FROM playerinfo WHERE teamID = ?");
    $stmt->bind_param("i", $teamID);
    $stmt->execute();
    $teamPlayers = $stmt->get_result();

    if ($result->num_rows > 0) {
        $teamTotals = $result->fetch_assoc();
    } else {
        die("Player not found.");
    }

    $stmt->close();
} else {
    die("Invalid team ID.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($fullName) ?> - Stats</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($fullName) ?></h1>
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
</body>
</html>
