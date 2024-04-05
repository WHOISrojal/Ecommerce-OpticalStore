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
        <h2>Featured Products</h2>
        <!-- <p>Summer Collection New Modern Design</p> -->
        <div class="pro-container">
            <div class="pro">
                <img src="image/products/f1.jpg" alt="">
                <div class="des">
                    <span>Burberry</span>
                    <h5>Sun Glasses</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Rs. 780</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/f2.jpg" alt="">
                <div class="des">
                    <span>Swarovski</span>
                    <h5>New Sunglass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 500</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/f3.jpg" alt="">
                <div class="des">
                    <span>RayBan</span>
                    <h5>Stylish Sunglass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 750</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/f4.jpg" alt="">
                <div class="des">
                    <span>Gucci</span>
                    <h5>Premium Eyewear</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <h4>Rs. 900</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/f13.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Glass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 300</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/f6.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Glass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 650</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/f114.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Contact Lense</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 120</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
            <div class="pro">
                <img src="image/products/f20.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Glass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 450</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrival</h2>
        <!-- <p>Summer Collection New Modern Design</p> -->
        <div class="pro-container">
        <div class="pro">
                <img src="image/products/f2.jpg" alt="">
                <div class="des">
                    <span>RayBan</span>
                    <h5>Sunglass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 700</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div><div class="pro">
                <img src="image/products/f1.jpg" alt="">
                <div class="des">
                    <span>Swarovski</span>
                    <h5>Sunglass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 800</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div><div class="pro">
                <img src="image/products/f18.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Eyeglass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 600</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div><div class="pro">
                <img src="image/products/f19.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Eyelass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 500</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div><div class="pro">
                <img src="image/products/f20.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Eyelass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 700</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div><div class="pro">
                <img src="image/products/f111.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Contact Lense</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 400</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div><div class="pro">
                <img src="image/products/f112.jpg" alt="">
                <div class="des">
                    <span>Prescription</span>
                    <h5>Contact Lense</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 400</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div><div class="pro">
                <img src="image/products/f4.jpg" alt="">
                <div class="des">
                    <span>Burberry</span>
                    <h5>Sunglass</h5>
                    <div class="star">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <i class="bi bi-star"></i>
                    </div>
                    <h4>Rs. 600</h4>
                </div>
                <a href="#"><i class="bi bi-bag-dash cart"></i></a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>