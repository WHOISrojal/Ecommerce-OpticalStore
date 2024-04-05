<?php
session_start();
include '../connection.php';

$message = '';

// Check if the admin or user is not logged in
if (!isset($_SESSION['username']) || ($_SESSION['user_type'] !== 'admin' && !$_SESSION['isloggedin'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category_name = $_POST["category_name"];

    // Prepare the SQL statement for updating the product
    $updateSql = "UPDATE products SET name=?, description=?, price=?, category_name=? WHERE id=?";
    $updateStmt = $con->prepare($updateSql);

    if ($updateStmt) {
        // Bind the parameters
        $updateStmt->bind_param("ssdsi", $name, $description, $price, $category_name, $id);

        // Execute the statement
        if ($updateStmt->execute()) {
            $message = "Product updated successfully.";
            // echo "Product updated successfully.";
        } else {
            echo "Error updating product: " . $updateStmt->error;
        }

        // Close the statement
        $updateStmt->close();
    } else {
        echo "Error in preparing SQL statement: " . $con->error;
    }
} else {
    // Handle product editing
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        // Fetch product details based on the ID from the URL
        $id = $_GET["id"];

        // Prepare the SQL statement
        $editSql = "SELECT * FROM products WHERE id = ?";
        $editStmt = $con->prepare($editSql);

        if ($editStmt === false) {
            displayError("Error in preparing SQL statement: " . $con->error);
        } else {
            // Bind the parameter
            $editStmt->bind_param("i", $id);

            // Execute the statement
            $editResult = $editStmt->execute();

            if ($editResult === false) {
                displayError("Error in executing SQL statement: " . $editStmt->error);
            } else {
                // Get the result
                $editResult = $editStmt->get_result();

                // Check if a row is fetched
                if ($editResult->num_rows > 0) {
                    // Fetch the data from the result
                    $editRow = $editResult->fetch_assoc();

                    // Display form with pre-filled data for editing
                    include 'header.php'; 
                    include 'sidebar.php'; 
                    echo "<main class='main-content'>";
                    echo "<a href='manageproducts.php'><i class='bi bi-arrow-left-circle-fill'></i></a>";
                    echo "<section id='addproduct-form'>";
                    echo "<div class='title-bar'>";
                    echo "<h2>Edit Product</h2>";
                    echo"</div>";
                    echo "<form action='update_product.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $editRow['id'] . "'>";
                    echo "Product Name: <input type='text' name='name' value='" . $editRow['name'] . "'><br>";
                    echo "Description: <input type='text' name='description' value='" . $editRow['description'] . "'><br>";
                    echo "Price: <input type='text' name='price' value='" . $editRow['price'] . "'><br>";
                    echo "<label for='category'>Category:</label>";
                    echo "<select id='category' name='category_name' required>";
                    echo "<option value='eyeglasses' " . ($editRow['category_name'] == 'eyeglasses' ? 'selected' : '') . ">Eyeglasses</option>";
                    echo "<option value='sunglasses' " . ($editRow['category_name'] == 'sunglasses' ? 'selected' : '') . ">Sunglasses</option>";
                    echo "<option value='lenses' " . ($editRow['category_name'] == 'lenses' ? 'selected' : '') . ">Lenses</option>";
                    echo "</select><br><br>";
                    echo "<input type='submit' class='submit-btn' value='Update Product'>";
                    echo "</form>";
                    echo"</section>";
                    echo"</main>";
                } else {
                    displayError("Product not found.");
                }
            }

            // Close the statement
            $editStmt->close();
        }
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
<?php
        // Display success message if there is one
        if (!empty($message)) {
            echo "<p style='color: green;'>$message</p>";
        }
        ?>
</body>

</html>