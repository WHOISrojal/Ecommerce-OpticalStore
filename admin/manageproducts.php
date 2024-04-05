<?php
session_start();
include '../connection.php';
include 'header.php'; 
include 'sidebar.php'; 


// Check if the admin or user is not logged in
if (!isset($_SESSION['username']) || ($_SESSION['user_type'] !== 'admin' && !$_SESSION['isloggedin'])) {
    header("Location: ../login.php");
    exit();
}

// Function to display an error message
function displayError($message)
{
    echo "<p style='color: red;'>Error: $message</p>";
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $con->query($sql);

if ($result === false) {
    displayError("Error in fetching products: " . $con->error);
} else {
    if ($result->num_rows > 0) {
        echo '<main class="main-content">';
        echo '<section class="customer-title">';
        echo '<h2 class="customer-tag">Manage Products</h2>';
        echo "<table class='manage-table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='th-id'>Product ID</th>";
        echo "<th class='th-name'>Product Name</th>";
        echo "<th class='th-description'>Description</th>";
        echo "<th class='th-price'>Price</th>";
        echo "<th class='th-price'>Category</th>";
        echo "<th class='th-image'>Image</th>";
        echo "<th class='th-actions'>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["id"] . "<br>";
            echo '<td>' . $row["name"] . "<br>";
            echo '<td>' . $row["description"] . "<br>";
            echo '<td>' . $row["price"] . "<br>";
            echo '<td>' . $row["category_name"] . "<br>";
            echo '<td><img src="../' . $row["image"] . '" alt="Product Image" style="width: 50px; height: 50px;"></td>';
            echo "<td>";
            echo "<a href='update_product.php?action=edit&id=" . $row["id"] . "'>Edit</a> | ";
            echo "<a href='delete_product.php?id=" . $row["id"] . "'>Delete</a><br><br>";
            echo "</td>";
            echo "</tr>";
            // Add more fields as needed
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No products found.";
    }
}



// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="astyle.css">
</head>
<body>
   
</body>
</html>

