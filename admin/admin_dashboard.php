<?php
session_start();
include '../loggedin.php';

// Check if the admin is not logged in or the general user is not logged in
if (!isset($_SESSION['username']) || ($_SESSION['user_type'] !== 'admin' && !$_SESSION['isloggedin'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch the total number of user accounts from the database
$userCountQuery = "SELECT COUNT(*) as totalUsers FROM users";
$userCountResult = mysqli_query($con, $userCountQuery);

if ($userCountResult) {
    $userCountData = mysqli_fetch_assoc($userCountResult);
    $totalUsers = $userCountData['totalUsers'];
} else {
    // Handle the database query error
    $totalUsers = 0;
}

// Fetch the total number of products from the database
$productCountQuery = "SELECT COUNT(*) as totalProducts FROM products";
$productCountResult = mysqli_query($con, $productCountQuery);

if ($productCountResult) {
    $productCountData = mysqli_fetch_assoc($productCountResult);
    $totalProducts = $productCountData['totalProducts'];
} else {
    // Handle the database query error
    $totalProducts = 0;
}

// Fetch the total number of orders from the database
$orderCountQuery = "SELECT COUNT(*) as totalOrders FROM orders";
$orderCountResult = mysqli_query($con, $orderCountQuery);

if ($orderCountResult) {
    $orderCountData = mysqli_fetch_assoc($orderCountResult);
    $totalOrders = $orderCountData['totalOrders'];
} else {
    // Handle the database query error
    $totalOrders = 0;
}
mysqli_close($con); // Close the database connection
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="astyle.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
        <section class="dashboard-container">
            <div class="metric" data-metric="users">
            <div class="usericon">
                <i class="bi bi-people-fill"></i>
            </div>
                <h3 class="metric-label">Total Users</h3>
                <span class="metric-number"><?php echo "<p>$totalUsers</p>";?></span>
            </div>
            <!-- <div class="metric" data-metric="categories">
                <h3 class="metric-label">Total Categories</h3>
                <span class="metric-number"></span>
            </div> -->
            <div class="metric1" data-metric="products">
            <i class="bi bi-dropbox"></i>
                <h3 class="metric-label">Total Products</h3>
                <span class="metric-number"><?php echo "<p>$totalProducts</p>";?></span>
            </div>
            <div class="metric2" data-metric="orders">
            <i class="bi bi-cart-check-fill"></i>
                <h3 class="metric-label">Total Orders</h3>
                <span class="metric-number"><?php echo "<p>$totalOrders</p>";?></span>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

