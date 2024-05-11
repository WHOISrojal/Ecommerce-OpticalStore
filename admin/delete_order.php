<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['username']) || ($_SESSION['user_type'] !== 'admin' && !$_SESSION['isloggedin'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Check if the order exists and delete it from the database
    $delete_query = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param('i', $order_id);

    if ($stmt->execute()) {
        echo "Order deleted successfully.";
    } else {
        echo "Error deleting order: " . $con->error;
    }

    $stmt->close();
    mysqli_close($con);
}
?>