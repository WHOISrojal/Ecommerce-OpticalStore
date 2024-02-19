<?php
include 'connection.php';

$totalItemsLoggedInUser = 0;
$totalItemsTemporaryCart = 0;

// Calculating cart count for the logged-in user
if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
    $cartQuery = "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?";
    $cartStmt = mysqli_prepare($con, $cartQuery);
    mysqli_stmt_bind_param($cartStmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($cartStmt);
    $cartResult = mysqli_stmt_get_result($cartStmt);

    if ($cartResult && $cartData = mysqli_fetch_assoc($cartResult)) {
        $totalItemsLoggedInUser = (int) $cartData['total'];
    }
}

// Calculating cart count for the temporary cart
if (isset($_SESSION['temporary_cart']) && !empty($_SESSION['temporary_cart'])) {
    $totalItemsTemporaryCart = array_sum(array_column($_SESSION['temporary_cart'], 'quantity'));
}

// Total cart count
$totalCartCount = $totalItemsLoggedInUser + $totalItemsTemporaryCart;

mysqli_close($con);
?>
