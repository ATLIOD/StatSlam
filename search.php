<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "statslam_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST["search"];

    $stmt = $conn->prepare("SELECT playerID FROM playerinfo WHERE name LIKE ?");
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("s", $searchParam);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $playerID = $row["playerID"];
            header(
                "Location: http://localhost/playerstats.php?playerID=" .
                    urlencode($playerID)
            );
            exit();
        } else {
            echo "No results found.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
