<?php
session_start();

// Check if the admin is not logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Add database connection code
include '../connection.php';

// Handle product deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Perform the delete operation
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo "Product deleted successfully.";
    } else {
        echo "Error: " . $con->error;
    }

    $stmt->close();
}

// Close the database connection
$con->close();
?>
