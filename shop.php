<?php
session_start();
include 'connection.php';
include 'cartCount.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reshmi Optical Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="header">
        <a href="index.php"><img src="image/logo/logo.png" class="logo" alt="This is a logo"></a>
        <div>
            <ul id="navbar">
                <?php include 'searchbtn.php' ?>
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="shop.php">Shop</a></li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <!-- <input type="search" id="q" name="q" placeholder="Search in Daraz" class="search-box__input--O34g" tabindex="1" value=""> -->
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

    <section id="page-header">
        <h2>Explore Accessories</h2>
        <p>Find large varieties of products</p>
    </section>

    <section id="product1" class="section-p1">
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

    <!-- <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="bi bi-chevron-right"></i></a>
    </section> -->

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>