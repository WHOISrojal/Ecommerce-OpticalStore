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
                <li><a href="about.php">About us</a></li>
                <li><a class="active" href="contact.php">Contact</a></li>
                <!-- <input type="search" id="q" name="q" placeholder="Search in Daraz" class="search-box__input--O34g" tabindex="1" value=""> -->
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li><?php echo "<p style='margin-top: 10px; margin-left: -20px; color: gray;'>$totalCartCount</p>"; ?>
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
        <h2>Contact Us</h2>
        <p>LEAVE A MESSAGE. We love to hear from you!</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit one of our agency locations or contact us today</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="bi bi-geo-alt"></i>
                    <p>Kathmandu, Nepal</p>
                </li>
                <li>
                    <i class="bi bi-envelope"></i>
                    <p>hello@gmail.com</p>
                </li>
                <li>
                    <i class="bi bi-telephone"></i>
                    <p>+977-9812345678</p>
                </li>
                <li>
                    <i class="bi bi-clock"></i>
                    <p>Sun-Fri, 10:00-20:00</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d220.7332051277766!2d85.3140715186452!3d27.72558194628648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1705779487683!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> </div>   </section>

    <section id="form-details">
        <form action="feedback.php" method="post">
            <span>LEAVE A MEASSAGE</span>
            <h2>We love to hear from you</h2>
            <input type="text" name="name" placeholder="John Doe">
            <input type="text" name="email" placeholder="john@gmail.com">
            <input type="text" name="subject" placeholder="Subject">
            <textarea name="message" id="" cols="30" rows="10" placeholder="Enter your message"></textarea>
            <div class="sub">
            <input type="submit" name=submit">
        </div>
        </form>

        <div class="people">
            <div>
                <img src="image/people/2.png" alt="">
                <p><span>Laxman Maharjan</span>Optician<br>Phone:091203921<br>Email:laxman@gmail.com</p>
            </div>
            <div>
                <img src="image/people/girl.jpg" alt="">
                <p><span>Renuka Maharjan</span>Manager<br>Phone:091203921<br>Email:renuka@gmail.com</p>
            </div>      
    </section>

    <?php include 'footer.php' ; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>