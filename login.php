<?php
session_start();
include 'connection.php';

// Initialize error message variable
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'user') {
        // If logged in, display an error message
        $error_message = "You are already logged in. Logout first to log in as another user.";
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $num_rows = mysqli_num_rows($result);

                if ($num_rows > 0) {
                    $row = mysqli_fetch_assoc($result);

                    if (password_verify($password, $row['password'])) {
                        if ($row['user_type'] == 'admin') {
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['user_type'] = 'admin';
                            $_SESSION['isloggedin'] = true;
                            $_SESSION['user_id'] = $row['user_id'];
                            $success_message = "Welcome admin, Redirecting to Dashboard";
                            header("Location: admin/admin_dashboard.php");
                            exit();
                        } else {
                            // Login successful!
                            $success_message = "Login successful, Now redirecting to the Home Page";
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['fullname'] = $row['fullname'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['user_type'] = 'user';
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['isloggedin'] = true;

                            // Transfer items from the temporary cart to the user's actual cart
                            if (isset($_SESSION['temporary_cart']) && !empty($_SESSION['temporary_cart'])) {
                                $temporaryCart = $_SESSION['temporary_cart'];

                                foreach ($temporaryCart as $productId => $item) {
                                    $quantity = $item['quantity'];

                                    $cartQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
                                    $cartStmt = mysqli_prepare($con, $cartQuery);
                                    mysqli_stmt_bind_param($cartStmt, "ii", $_SESSION['user_id'], $productId);
                                    mysqli_stmt_execute($cartStmt);
                                    $cartResult = mysqli_stmt_get_result($cartStmt);

                                    if ($cartResult && $cartItem = mysqli_fetch_assoc($cartResult)) {
                                        // Product is already in the cart for the logged-in user, update quantity
                                        $newQuantity = $cartItem['quantity'] + $quantity;
                                        $updateQuery = "UPDATE cart SET quantity = ? WHERE id = ?";
                                        $updateStmt = mysqli_prepare($con, $updateQuery);
                                        mysqli_stmt_bind_param($updateStmt, "ii", $newQuantity, $cartItem['id']);
                                        mysqli_stmt_execute($updateStmt);
                                    } else {
                                        // Product is not in the cart for the logged-in user, add it
                                        $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
                                        $insertStmt = mysqli_prepare($con, $insertQuery);
                                        mysqli_stmt_bind_param($insertStmt, "iii", $_SESSION['user_id'], $productId, $quantity);
                                        mysqli_stmt_execute($insertStmt);
                                    }
                                }

                                // Clear the temporary cart after transferring items
                                unset($_SESSION['temporary_cart']);
                            }

                            // Redirect the user to the home page or another desired location
                            header("Location: index.php");
                            exit();
                        }
                    } else {
                        $error_message = "Invalid username or password";
                    }
                } else {
                    $error_message = "Invalid username or password";
                }
            } else {
                error_log("Error: " . $sql . "<br>" . mysqli_error($con));
            }

            mysqli_stmt_close($stmt);
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
                <!-- <input type="search" id="q" name="q" placeholder="Search in Daraz" class="search-box__input--O34g" tabindex="1" value=""> -->
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li><?php include 'cartCount.php';                                                                           echo "<p style='margin-top: 10px; margin-left: -20px; color: gray;'>$totalCartCount</p>"; ?>
                <li><a class="active" href="login.php"><i class="bi bi-person"></i></a></li><?php include 'loggedin.php';$welcomeMessage = "$username! <a href='logout.php'>Logout</a>"; ?>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>

    <section id="login-form" class="section-p1">
        <h2>User Login</h2>

        <?php
        // Display error message if there is one
        if (!empty($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }

        // Display success message if there is one
        if (!empty($success_message)) {
            echo "<p style='color: green;'>$success_message</p>";
        }
        ?>
        <!--  Display the login form only if no user is logged in -->
        <!-- if (!isset($_SESSION['username']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'user') { -->
        <form action="login.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Submit"><br>
            <p>Don't have an account! <a href="register.php">Register here</a></p>
        </form>


    </section>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>




<!-- // Display error in an alert

        session_start()
        if (isset($_SESSION['error'])) {
            echo "<script>alert('" . $_SESSION['error'] . "');</script>";
            unset($_SESSION['error']); // Clear the error after displaying it
        }
         -->