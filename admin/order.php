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

    <main class="main-content">
        <section class="customer-title">
            <h2 class="customer-tag">Orders</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Product ID</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Created At</th>
                        <th>Transaction ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM orders ORDER BY created_at DESC";
                    $result = mysqli_query($con, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['order_id'] . '</td>';
                            echo '<td>' . $row['customer_id'] . '</td>';
                            echo '<td>' . $row['product_id'] . '</td>';
                            echo '<td>' . $row['total_amount'] . '</td>';
                            echo '<td>' . $row['payment_status'] . '</td>';
                            echo '<td>' . $row['created_at'] . '</td>';
                            echo '<td>' . $row['transaction_id'] . '</td>';
                            echo '<td>';
                            // echo '<a href="edit_order.php?id=' . $row['order_id'] . '">Edit</a> | ';
                            echo '<a href="delete_order.php?id=' . $row['order_id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8">No orders found.</td></tr>';
                    }

                    mysqli_free_result($result);
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <?php mysqli_close($con); ?>
</body>

</html>