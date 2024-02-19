<?php
session_start();
include 'cartCount.php';
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
                <li><a class="active" href="about.php">About us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <!-- <input type="search" id="q" name="q" placeholder="Search in Daraz" class="search-box__input--O34g" tabindex="1" value=""> -->
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li><?php echo "<p style='margin-top: 10px; margin-left: -20px; color: gray;'>($totalCartCount)</p>"; ?>
                <li><a href="login.php"><i class="bi bi-person"></i></a></li><?php include'loggedin.php';$welcomeMessage = "$username! <a href='logout.php'>Logout</a>";?>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>Know us</h2>
        <p>Everything</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="image/about/a6.jpg" alt="">
        <div>
            <h2>Who are we?</h2>
            <p>Reshmi Optical Center</p>
            <abbr title="">Reshmi Optical Center</abbr>

            <br>

            <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">Reshmi Optical Center</marquee>
        </div>
    </section>

    <section id="about-app" class="section-p1">
        <div class="video">
        <video autoplay loop src="image/about/optical.mp4"></video>
        </div>
    </section>

    <?php include 'footer.php' ; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>