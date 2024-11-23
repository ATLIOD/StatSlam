<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from form
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate inputs
    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($password)
    ) {
        die("Please fill in all fields.");
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "statslam_db"); // Replace with your DB credentials

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT userID FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email already registered. Please use a different one.";
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare(
            "INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssss",
            $first_name,
            $last_name,
            $email,
            $hashed_password
        );

        if ($stmt->execute()) {
            // Redirect to login page after successful signup
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request method.");
}

?>
