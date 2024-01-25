<?php
session_start();

// Check if the admin is not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Add database connection code
include 'connection.php';

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Product ID: " . $row["product_id"] . "<br>";
        echo "Product Name: " . $row["product_name"] . "<br>";
        echo "Description: " . $row["description"] . "<br>";
        echo "Price: $" . $row["price"] . "<br>";
        echo "<a href='edit_product.php?id=" . $row["product_id"] . "'>Edit</a> | ";
        echo "<a href='delete_product.php?id=" . $row["product_id"] . "'>Delete</a><br><br>";
        // Add more fields as needed
    }
} else {
    echo "No products found.";
}
?>
