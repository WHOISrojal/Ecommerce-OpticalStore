<?php
session_start();
include 'connection.php';

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST["admin_username"];
    $admin_password = $_POST["admin_password"];

    // Validate admin credentials (replace with your admin credentials)
    if ($admin_username == "admin" && $admin_password == "admin") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form action="admin_login.php" method="post">
        <label for="adminname">Username:</label>
        <input type="text" name="admin_username" required><br>

        <label for="adminpassword">Password:</label>
        <input type="password" name="admin_password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>