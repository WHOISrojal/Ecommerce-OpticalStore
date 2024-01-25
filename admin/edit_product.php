<!-- edit_product.php -->
<?php
// Fetch product details based on the ID from the URL
$product_id = $_GET["id"];
$sql = "SELECT * FROM products WHERE product_id = $product_id";
// Add code to fetch data from the database

// Display form with pre-filled data for editing
?>

<!-- delete_product.php -->
<?php
// Fetch product details based on the ID from the URL
$product_id = $_GET["id"];
$sql = "SELECT * FROM products WHERE product_id = $product_id";
// Add code to fetch data from the database

// Display confirmation message and form for deletion
?>
