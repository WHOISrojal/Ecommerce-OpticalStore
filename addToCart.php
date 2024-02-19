<?php 
session_start();
?>

<?php 
// include 'connection.php';

// if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['product_id'])) {
//     $productId = $_GET['product_id'];
    
//     // Check if the product exists
//     $productQuery = "SELECT * FROM products WHERE id = ?";
//     $productStmt = mysqli_prepare($con, $productQuery);
//     mysqli_stmt_bind_param($productStmt, "i", $productId);
//     mysqli_stmt_execute($productStmt);
//     $productResult = mysqli_stmt_get_result($productStmt);

//     if ($productResult && $product = mysqli_fetch_assoc($productResult)) {
//         // Product exists, check if user is logged in
//         if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
//             $userId = $_SESSION['user_id'];
            
//             // Check if the product is already in the cart
//             $cartQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
//             $cartStmt = mysqli_prepare($con, $cartQuery);
//             mysqli_stmt_bind_param($cartStmt, "ii", $userId, $productId);
//             mysqli_stmt_execute($cartStmt);
//             $cartResult = mysqli_stmt_get_result($cartStmt);

//             if ($cartResult && $cartItem = mysqli_fetch_assoc($cartResult)) {
//                 // Product is already in the cart, update quantity
//                 $newQuantity = $cartItem['quantity'] + 1;
//                 $updateQuery = "UPDATE cart SET quantity = ? WHERE id = ?";
//                 $updateStmt = mysqli_prepare($con, $updateQuery);
//                 mysqli_stmt_bind_param($updateStmt, "ii", $newQuantity, $cartItem['id']);
//                 mysqli_stmt_execute($updateStmt);
//             } else {
//                 // Product is not in the cart, add it
//                 $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
//                 $insertStmt = mysqli_prepare($con, $insertQuery);
//                 mysqli_stmt_bind_param($insertStmt, "ii", $userId, $productId);
//                 mysqli_stmt_execute($insertStmt);
//             }

//             echo "Product added to the cart successfully.";
//         } else {
//             // User is not logged in, handle accordingly (redirect to login, show a message, etc.)
//             echo "Please log in to add products to the cart.";
//         }
//     } else {
//         // Product not found, handle accordingly
//         echo "Product not found.";
//     }
// } else {
//     // Invalid request, handle accordingly
//     echo "Invalid request.";
// }

// mysqli_close($con);
?>




<?php 
include 'connection.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    
    // Check if the product exists
    $productQuery = "SELECT * FROM products WHERE id = ?";
    $productStmt = mysqli_prepare($con, $productQuery);
    mysqli_stmt_bind_param($productStmt, "i", $productId);
    mysqli_stmt_execute($productStmt);
    $productResult = mysqli_stmt_get_result($productStmt);

    if ($productResult && $product = mysqli_fetch_assoc($productResult)) {
        // Product exists, check if user is logged in
        if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
            $userId = $_SESSION['user_id'];
            
            // Check if the product is already in the cart for the logged-in user
            $cartQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
            $cartStmt = mysqli_prepare($con, $cartQuery);
            mysqli_stmt_bind_param($cartStmt, "ii", $userId, $productId);
            mysqli_stmt_execute($cartStmt);
            $cartResult = mysqli_stmt_get_result($cartStmt);

            if ($cartResult && $cartItem = mysqli_fetch_assoc($cartResult)) {
                // Product is already in the cart for the logged-in user, update quantity
                $newQuantity = $cartItem['quantity'] + 1;
                $updateQuery = "UPDATE cart SET quantity = ? WHERE id = ?";
                $updateStmt = mysqli_prepare($con, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, "ii", $newQuantity, $cartItem['id']);
                mysqli_stmt_execute($updateStmt);
            } else {
                // Product is not in the cart for the logged-in user, add it
                $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
                $insertStmt = mysqli_prepare($con, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, "ii", $userId, $productId);
                mysqli_stmt_execute($insertStmt);
            }

            // echo "Product added to the cart successfully.";
            $message = "Product added to the cart successfully.";
        } else {
            
            // User is not logged in, add the product to a temporary session cart
            if (!isset($_SESSION['temporary_cart'])) {
                $_SESSION['temporary_cart'] = [];
            }

            // Check if the product is already in the temporary cart
            $temporaryCart = &$_SESSION['temporary_cart'];
            if (array_key_exists($productId, $temporaryCart)) {
                // Product is already in the temporary cart, update quantity
                $temporaryCart[$productId]['quantity'] += 1;
            } else {
                // Product is not in the temporary cart, add it
                $temporaryCart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => 1
                ];
            }
            // echo "Product added to the temporary cart. Please log in to save your cart.";
            $message = "Product added to the temporary cart. Please log in to save your cart.";
        }
        header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
    } else {
        // Product not found, handle accordingly
        // echo "Product not found.";
        $message = "Product not found";
    }
} else {
    // Invalid request, handle accordingly
    // echo "Invalid request.";
    $message = "Invalid request.";
}

mysqli_close($con);
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
</head>

<body>
<script>
    // Display a message indicating that the item has been added to the cart
    var messageDiv = document.createElement("div");
    messageDiv.innerHTML = "<?php echo $message; ?>";
    messageDiv.style.cssText = "position: fixed; top: 0; left: 0; width: 100%; background-color: #f2f2f2; padding: 10px; text-align: center; font-weight: bold;";
    document.body.appendChild(messageDiv);

    // Remove the message after 3 seconds (adjust as needed)
    setTimeout(function() {
        document.body.removeChild(messageDiv);
    }, 3000);

    // Redirect back to the previous page after displaying the message
    setTimeout(function() {
        window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
    }, 3000);
</script>
</body>

</html> -->
