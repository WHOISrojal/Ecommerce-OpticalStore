<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['username']) || ($_SESSION['user_type'] !== 'admin' && !$_SESSION['isloggedin'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Fetch order details from the database based on $order_id

    // Code to update order upon form submission
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="astyle.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
        <section class="customer-title">
            <h2 class="customer-tag">Edit Order</h2>
            <form method="POST" action="">
                <!-- Display form fields with pre-filled order details -->
                <!-- Example: <input type="text" name="customer_name" value="<?php echo $customer_name; ?>"> -->
                <input type="submit" name="submit" value="Update Order">
            </form>
        </section>
    </main>

    <?php mysqli_close($con); ?>
</body>
</html>