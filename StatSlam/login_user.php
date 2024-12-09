<?php
session_start(); //start session

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "root", "statslam_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the user
    $stmt = $conn->prepare(
        "SELECT userID, email, password FROM user WHERE email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $email, $hashedPassword);
        $stmt->fetch();

        // **validate entered password with hashed password**
        if (password_verify($password, $hashedPassword)) {
            // Successful login
            $_SESSION["userID"] = $id;
            $_SESSION["email"] = $email;

            // Redirect to homepage
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this username.";
    }

    $stmt->close();
    $conn->close();
}

?>
