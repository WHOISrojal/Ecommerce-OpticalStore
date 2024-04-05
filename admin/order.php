<?php
session_start();
include '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="astyle.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
</body>

</html>

<?php

if (!isset($_SESSION['username']) || ($_SESSION['user_type'] !== 'admin' && !$_SESSION['isloggedin'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch orders data from the database
$query = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

// Check if there is any orders data
if ($result) {
    echo '<main class="main-content">';
    echo '<section class="customer-title">';
    echo '<h2 class="customer-tag">Orders</h2>';
    echo '<table class="table table-bordered table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo "<th>Order ID</th>";
    echo "<th>Customer ID</th>";
    echo "<th>Product ID</th>";
    echo "<th>Total Amount</th>";
    echo "<th>Payment Status</th>";
    echo "<th>Created At</th>";
    echo "<th>Transaction ID</th>";
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['order_id'] . '</td>';
        echo '<td>' . $row['customer_id'] . '</td>';
        echo '<td>' . $row['product_id'] . '</td>';
        echo '<td>' . $row['total_amount'] . '</td>';
        echo '<td>' . $row['payment_status'] . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '<td>' . $row['transaction_id'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</section>';
    echo '</main>';

    mysqli_free_result($result);
} else {
    // Handle error if needed
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>