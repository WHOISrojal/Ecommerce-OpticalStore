<?php
session_start();
include 'connection.php';

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch product details from the database based on the product ID
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);

    // Check if the statement is prepared successfully
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $productId); // 'i' indicates integer type

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Get result
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $productDetails = mysqli_fetch_assoc($result);
            $productName = $productDetails['name'];
            $productDescription = $productDetails['description'];
            $productPrice = $productDetails['price'];
            $productImagePath = $productDetails['image'];
            $productCategory = $productDetails['category_name'];
        } else {
            // Handle the case where the product is not found
            // echo "Product not found";
            header("Location: shop.php"); // Redirect to the shop page for example
            exit();
        }
    } else {
        // Handle the case where the product ID is not provided in the URL
        // echo "Product id not provided";
        header("Location: shop.php"); // Redirect to the shop page for example
        exit();
    }
} else {
    // Handle the case where the product ID is not provided in the URL
    // Redirect or show an error message
    // echo "Product id not provided";
    header("Location: shop.php"); // Redirect to the shop page for example
    exit();
}
mysqli_stmt_close($stmt);
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
                <li><a class="active" href="shop.php">Shop</a></li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <!-- <input type="search" id="q" name="q" placeholder="Search in Daraz" class="search-box__input--O34g" tabindex="1" value=""> -->
                <?php include 'cartCount.php'; ?>
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li><?php echo "<p style='margin-top: 10px; margin-left: -20px; color: gray;'>($totalCartCount)</p>"; ?>
                <li><a href="login.php"><i class="bi bi-person"></i></a></li><?php include 'loggedin.php';$welcomeMessage = "$username! <a href='logout.php'>Logout</a>"; ?>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>

    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <!-- <img src="image/products/f1.jpg" width="100%" id="MainImg" alt=""> -->

            <?php
            // Retrieve the image path from URL parameter
            // $imagePath = isset($_GET['imagePath']) ? $_GET['imagePath'] : 'default-image.jpg';
            ?>
            <img src="<?php echo $productImagePath; ?>" width="100%" id="MainImg" alt="Selected Product Image">

            <!-- small image  
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="image/products/f1.jpg" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="image/products/f2.jpg" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="image/products/f3.jpg" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="image/products/f4.jpg" width="100%" class="small-img" alt="">
                </div>
            </div> -->

        </div>

        <div class="single-pro-details">
            <h6>Product Category:<?php echo $productCategory; ?></h6>
            <h4><?php echo $productName; ?></h4>
            <h6>Product Details:</h6>
            <span><?php echo $productDescription; ?></span><br><br>
            <h2>Rs. <?php echo $productPrice; ?></h2>
            <input type="number" value="1">
            <a href='addToCart.php?product_id=<?php echo $productId ?>'>
                <button class="normal">Add to Cart</button>
            </a>

            <!-- <h4>Men's Fashion T-shirt</h4>
            <h2>$139.00</h2>
            <input type="number" value="1">
            <button class="normal">Add to Cart</button>
            <h4>Product Details</h4>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing ut dolorum aut nam quasi natus voluptas dolore?</span> -->
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <div class="pro">
                <img src="image/products/n1.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-shirt</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/n2.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-shirt</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/n3.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-shirt</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/n4.jpg" alt="">
                <div class="des">
                    <span>adidas</span>
                    <h5>Cartoon Astronaut T-shirt</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>$78</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        let MainImg = document.getElementById("MainImg");
        let smallimg = document.getElementsByClassName("small-img");
        smallimg[0].onclick = function() {
            MainImg.src = smallimg[0].src;
        }
        smallimg[1].onclick = function() {
            MainImg.src = smallimg[1].src;
        }
        smallimg[2].onclick = function() {
            MainImg.src = smallimg[2].src;
        }
        smallimg[3].onclick = function() {
            MainImg.src = smallimg[3].src;
        }
    </script>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>