<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "statslam_db"); // Replace with your DB credentials

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

        // **Verify the entered password against the hashed password**
        if (password_verify($password, $hashedPassword)) {
            // Successful login
            $_SESSION["userID"] = $id;
            $_SESSION["email"] = $email;

            // Redirect to dashboard
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
