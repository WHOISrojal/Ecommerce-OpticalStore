<?php
session_start();
include 'connection.php';
// include 'cartCount.php';
// include 'loggedin.php';
$transaction_id=$_GET['transaction_id'];
$stmtreceipt= $con->prepare("SELECT description from receipt WHERE transaction_id=?");
$stmtreceipt->bind_param("s",$transaction_id);
$stmtreceipt->execute();
$stmtreceipt= $stmtreceipt->get_result();
$getreceipt = $stmtreceipt->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reshmi Optical Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* .receipt-container{
            display: flex;
            justify-content: center;
        } */
</style>
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
                <?php include'cartCount.php'; ?><li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li><?php echo "<p style='margin-top: 10px; margin-left: -20px; color: gray;'>($totalCartCount)</p>"; ?>
                <li><a href="login.php"><i class="bi bi-person"></i></a></li><?php include 'loggedin.php';$welcomeMessage = "$username! <a href='logout.php'>Logout</a>"; ?>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>
    <div class="container">
    <?php
    echo $getreceipt['description'];
    ?>
    </div>
    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>