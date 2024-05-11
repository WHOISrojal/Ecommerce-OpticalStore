<?php
session_start();
include 'connection.php';
include 'cartCount.php';
// include 'loggedin.php';
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
    <?php 
    // $currentPage = 'home';
    // include 'header.php'; 
    ?>
    <section id="header">
        <a href="index.php"><img src="image/logo/logo.png" class="logo" alt="This is a logo"></a>
        <div>
            <ul id="navbar">
                <!-- <li id="lg-search"><input type="text" placeholder="Search for products" class="search-box" style="height: 4vh; width: 25vw; padding: 8px; border:none; border-radius: 10px; margin-right: 5px;"><button style="height: 4vh; width: 2vw; border: none; border-radius: 6px;"><a href="#"><i class="bi bi-search"></i></a></button></li> -->
                <?php include 'searchbtn.php' ?>
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li><?php echo "<p style='margin-top: 10px; margin-left: -20px; color: gray;'>$totalCartCount</p>"; ?>
                <li><a href="login.php"><i class="bi bi-person"></i></a></li><?php include 'loggedin.php';$welcomeMessage = "$username! <a href='logout.php'>Logout</a>"; ?>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>

    <section id="frontimg">
        <h4>2024</h4>
        <h2>Hot Deals</h2>
        <h1>On all Accessories</h1>
        <!-- <p>Save more with coupons & up tp 70% off! </p> -->
        <a href="shop.php"><button>Shop now</button></a>
    </section>

    <section id="feature" class="section-p1">
    <div class="fe-box">
        <a href="featureproduct.php?category=eyeglasses">
            <img src="image/features/f1.png" alt="Feature 1">
        </a>
        <h6>Eyeglasses</h6>
    </div>
    <div class="fe-box">
        <a href="featureproduct.php?category=sunglasses">
            <img src="image/features/f2.png" alt="Feature 2">
        </a>
        <h6>Sunglasses</h6>
    </div>
    <div class="fe-box">
        <a href="featureproduct.php?category=lenses">
            <img src="image/features/f3.png" alt="Feature 3">
        </a>
        <h6>Lenses</h6>
    </div>

        <!-- <div class="fe-box">
            <img src="image/features/f4.png" alt="Feature 4">
            <h6>Promotions</h6>
        </div>
        <div class="fe-box">
            <img src="image/features/f5.png" alt="Feature 5">
            <h6>Happy Sale</h6>
        </div>
        <div class="fe-box">
            <img src="image/features/f6.png" alt="Feature 6">
            <h6>F24/7 Support</h6>
        </div> -->
    </section>

    <section id="product1" class="section-p1">
        <h2>Featured Product</h2>
        <div class="pro-container">
            <?php

            // Check if a search term is provided
            if (isset($_GET['search'])) {
                $searchTerm = mysqli_real_escape_string($con, $_GET['search']);
                $sql = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";
            } else {
                // If no search term is provided, fetch all products
                $sql = "SELECT * FROM products";
            }

            $result = mysqli_query($con, $sql);

            // Display products
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $productId = $row['id'];
                    $imagePath = $row['image'];
                    echo "<div class='pro'>";
                    echo "<a href='sproduct.php?id=" . $productId . "'>";
                    echo "<img src='" . $imagePath . "' alt='" . $row['name'] . "'>";
                    echo "</a>";
                    echo "<div class='des'>";
                    echo "<span>" . $row['name'] . "</span>";
                    echo "<h5>" . $row['description'] . "</h5>";
                    echo "<div class='star'></div>";
                    echo "<h4>Rs. " . $row['price'] . "</h4>";
                    echo "</div>";
                    // echo "<a href='#'><i class='bi bi-bag-dash cart'></i></a>";
                    echo "<a href='addToCart.php?product_id=" . $row['id'] . "'><i class='bi bi-bag-dash cart'></i></a>";
                    echo "</div>";
                }
                mysqli_free_result($result);
            } else {
                echo "Error: " . mysqli_error($con);
            }

            mysqli_close($con);
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>