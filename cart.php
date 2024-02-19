<?php
session_start();
include 'connection.php';

$totalPrice = 0;
$totalItemsLoggedInUser = 0;
$totalItemsTemporaryCart = 0;
$cartCount = '';

// Initializing $cartResult to null
$cartResult = null;

if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {

    // Fetch products in the cart for the logged-in user
    $cartQuery = "SELECT cart.id, products.name, products.image, products.price, cart.quantity
    FROM cart
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?";
    $cartStmt = mysqli_prepare($con, $cartQuery);
    mysqli_stmt_bind_param($cartStmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($cartStmt);
    $cartResult = mysqli_stmt_get_result($cartStmt);
} 
elseif (isset($_SESSION['temporary_cart']) && !empty($_SESSION['temporary_cart'])) {
    // User is not logged in, but temporary cart exists
    $temporaryCart = $_SESSION['temporary_cart'];

    // Fetch products in the temporary cart
    $temporaryCartProducts = [];
    foreach ($temporaryCart as $productId => $item) {
        $productQuery = "SELECT * FROM products WHERE id = ?";
        $productStmt = mysqli_prepare($con, $productQuery);
        mysqli_stmt_bind_param($productStmt, "i", $productId);
        mysqli_stmt_execute($productStmt);
        $productResult = mysqli_stmt_get_result($productStmt);

        if ($productResult && $product = mysqli_fetch_assoc($productResult)) {
            $temporaryCartProducts[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => $product['price'],
                'quantity' => $item['quantity'],
            ];
            // Update total price for the unlogged user
            $totalPrice += $product['price'] * $item['quantity']; // Update total price
            $totalItemsTemporaryCart += $item['quantity']; // Update total items count
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reshmi Optical Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="image/logo/logo.png" class="logo" alt="This is a logo"></a>
        <div>
            <ul id="navbar">
                <?php include 'searchbtn.php' ?>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li id="lg-bag"><a class="active" href="cart.php"><i class="bi bi-bag-dash"></i></a></li> 
                <li><a href="login.php"><i class="bi bi-person"></i></a></li><?php include 'loggedin.php';$welcomeMessage = "$username! <a href='logout.php'>Logout</a>"; ?>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>SHOPPING BAG</h2>
    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display products in the cart of logged-in user
                if (!empty($cartResult)) {
                    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                        // Update the total price for the logged-in user
                         $totalPrice += $cartItem['price'] * $cartItem['quantity'];
                         $totalItemsLoggedInUser += $cartItem['quantity']; // Update total items count
                         displayCartItem($cartItem);
                    }
                }

                // Display products in the temporary cart
                if (!empty($temporaryCartProducts)) {
                    foreach ($temporaryCartProducts as $tempCartItem) {
                        displayCartItem($tempCartItem);
                    }
                }

                $cartCount = "$totalItemsLoggedInUser" + "$totalItemsTemporaryCart";
                echo "<h3 style='text-align: center; padding-bottom: 30px; color: grey;'>You have $cartCount items in the cart</h3>";

                // Function to display a cart item
                function displayCartItem($cartItem)
                {
                    global $totalPrice;
                    $subtotal = $cartItem['price'] * $cartItem['quantity'];
                    echo "<tr>
                        <td><a href='remove_from_cart.php?id={$cartItem['id']}'><i class='bi bi-x-circle'></i></a></td>
                        <td><img src='{$cartItem['image']}' alt='Product Image'></td>
                        <td>{$cartItem['name']}</td>
                        <td>\${$cartItem['price']}</td>
                        <td><input type='number' value='{$cartItem['quantity']}'></td>
                        <td>\${$subtotal}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
    <section id="cart-add" class="section-p1">
    <div id="subtotal">
        <h3>Cart Totals</h3>
        <table>
            <tr>
                <td>Cart Subtotal</td>
                <td>Rs. <?php echo number_format($totalPrice, 2); ?></td>
            </tr>
            <tr>
                <td>Shipping cost</td>
                <td>Free</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>Rs. <?php echo number_format($totalPrice, 2); ?></strong></td>
            </tr>
        </table>
        <button class="normal">Proceed to Checkout</button>
        <div class="cart-count">
        <!-- cart.php ma matrai cartkocount dekhauna lai yo tala ko code use gareko cha ani mathi header ma chai-->
        <?php $cartCount = "$totalItemsLoggedInUser" + "$totalItemsTemporaryCart";
        ?>
        </div>
    </div>
</section>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php

mysqli_close($con);
?>