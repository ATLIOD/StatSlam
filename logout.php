<?php
session_start(); // Start the session
session_unset(); // Unset variables
session_destroy(); // Destroy the session
header("Location: login.php"); // Redirect to login page
exit();
?>
