<?php
session_start();
include 'connection.php';

// Handle product deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the user is logged in
    if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
        // User is logged in, delete from the database
        $sql = "DELETE FROM cart WHERE id = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            echo "Product deleted successfully.";
        } else {
            echo "Error: " . $con->error;
        }

        $stmt->close();
    } else {
        // User is not logged in, delete from the session
        if (isset($_SESSION['temporary_cart']) && !empty($_SESSION['temporary_cart'])) {
            foreach ($_SESSION['temporary_cart'] as $key => $cartItem) {
                if ($cartItem['product_id'] == $id) {
                    unset($_SESSION['temporary_cart'][$key]);
                    echo "Product deleted successfully.";
                    break; // Exit the loop after deletion
                }
            }
        } else {
            echo "Error: Cart not found in session or is empty.";
        }
    }

    // Redirect the user to cart.php
    header("Location: cart.php");
    exit();
}

// Close the database connection
mysqli_close($con);
?>
