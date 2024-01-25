<?php
session_start(); //Started the seeion

include 'connection.php';

//Initialize error message variable
$error_message = '';
$success_message = '';

//Check if from is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'user') {
    // If logged in, display an error message
    $error_message = "You are already logged in. Logout first to log in as another user.";
}else{
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    // $result = mysqli_query($con, $sql);
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // mysqli_stmt_bind_param($stmt, "s", $username);
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
                    $success_message = "Welcome admin, Redirecting to Dashboard";
                    header("Location: admin_dashboard.php");
                    exit();
                    
                } else {
                // echo "Login successful!";
                $success_message = "Login successful, Now redirecting to the Login Page";
                $_SESSION['username'] = $row['username']; // Assuming user_id is a unique identifier for users
                $_SESSION['user_type'] = 'user';
                // You can redirect the user to their dashboard or another page
                header("Location: index.php");
                // header("refresh:2;url=index.php");
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
                <div class="searchbar">
                <li id="lg-search"><input type="text" placeholder="Search for products" class="search-box" style="height: 4vh; width: 25vw; padding: 8px; border:none; border-radius: 10px; margin-right: 10px;"><a href="#"><i class="bi bi-search"></i></a></li>
                </div>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <!-- <input type="search" id="q" name="q" placeholder="Search in Daraz" class="search-box__input--O34g" tabindex="1" value=""> -->
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li>
                <li><a href="login.php"><i class="bi bi-person"></i></a></li><?php include'loggedin.php';$welcomeMessage = "$username! <a href='logout.php'>Logout</a>";?>
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
            <a href="register.php">Create new account</a>
        </form>

        
    </section>

    <?php include 'footer.php' ; ?>

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