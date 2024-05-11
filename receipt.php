<?php
session_start();
include 'connection.php';

// Check if the user is logged in or identify the user in some way
if (!isset($_SESSION['user_id'])) {
    // Redirect or handle unauthorized access
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve the user's transaction ID from the receipt table
$stmtreceipt = $con->prepare("SELECT description, transaction_id FROM receipt WHERE user_id=?");
$stmtreceipt->bind_param("i", $user_id);
$stmtreceipt->execute();
$stmtreceipt = $stmtreceipt->get_result();
$receipts = $stmtreceipt->fetch_all(MYSQLI_ASSOC);

// Check if receipts are found
if (empty($receipts)) {
    echo "No receipts found for this user.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipts</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
                <?php include 'cartCount.php'; ?><li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li><?php echo "<p style='margin-top: 10px; margin-left: -20px; color: gray;'>$totalCartCount</p>"; ?>
                <li><a href="login.php"><i class="bi bi-person"></i></a></li><?php include 'loggedin.php';
                                                                                $welcomeMessage = "$username! <a href='logout.php'>Logout</a>"; ?>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>

    <h1 align="center">Receipts for User</h1>
    <div class="receipt-container">
        <table style="border: 1px solid black;">
            <?php foreach ($receipts as $receipt) : ?>
                <tbody>
                    <td>Transaction ID : <?php echo $receipt['transaction_id']; ?> </td>
                    <tr>
                        <td><?php echo $receipt['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
        </table>
    </div>
    <?php include 'footer.php' ?>
</body>

</html>