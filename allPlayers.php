<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "statslam_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current page number from the URL (default to page 1)
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
$perPage = 50; // Number of players per page

// Calculate the offset
$offset = ($page - 1) * $perPage;

// Fetch players with stats for the current page
$sql = "
SELECT playerinfo.playerID, playerinfo.name, playertotals.*
FROM playerinfo
INNER JOIN playertotals ON playerinfo.playerID = playertotals.playerID
LIMIT $perPage OFFSET $offset
";
$result = $conn->query($sql);

// Fetch total number of players for pagination
$totalPlayers = $conn
    ->query(
        "
    SELECT COUNT(*) as total
    FROM playertotals
"
    )
    ->fetch_assoc()["total"];
$totalPages = ceil($totalPlayers / $perPage);
?>

<!DOCTYPE html>
<html>
<head>
  <title>
    All Players
  </title>
  <link rel="stylesheet" href="index.css">
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
    </div>

    <div class="topnav">
        <a href="index.php">Home</a>
        <a class="active" href="allPlayers.php">Players</a>
        <a href="pricing.php">Pricing</a>
        <a href="login.php">Login</a>
        <a href="signUp.php">Sign Up</a>
        <a href="contact.php">Contact</a>
      </div>    <h1>Player Stats</h1>
    <div id="players-list">

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Player Name</th>
                    <th>Points</th>
                    <th>Field Goals Attempted</th>
                    <th>Field Goals Made</th>
                    <th>Field Goal Percentage</th>
                    <th>Two Pointers Attempted</th>
                    <th>Two Pointers Made</th>
                    <th>Two Pointer Percentage</th>
                    <th>Three Pointers Attempted</th>
                    <th>Three Pointers Made</th>
                    <th>Three Pointer Percentage</th>
                    <th>Free Throws Attempted</th>
                    <th>Free Throws Made</th>
                    <th>Free Throw Percentage</th>
                    <th>Offensive Rebounds</th>
                    <th>Defensive Rebounds</th>
                    <th>Assists</th>
                    <th>Blocks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <a href="playerstats.php?playerID=<?php echo htmlspecialchars(
                                $row["playerID"]
                            ); ?>">
                                <?php echo htmlspecialchars($row["name"]); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($row["points"]); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["fieldGoalsAttempted"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["fieldGoalsMade"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["fieldGoalPercentage"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["twoPointersAttempted"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["twoPointersMade"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["twoPointerPercentage"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["threePointersAttempted"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["threePointersMade"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["threePointerPercentage"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["freeThrowsAttempted"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["freeThrowsMade"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["freeThrowPercentage"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["offensiveRebounds"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["defensiveRebounds"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["assists"]
                        ); ?></td>
                        <td><?php echo htmlspecialchars($row["blocks"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div id="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) {
    echo 'style="font-weight:bold;"';
} ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close();
?>
