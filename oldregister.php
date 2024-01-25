
<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($con, $_POST["fullname"]);
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $repassword = mysqli_real_escape_string($con, $_POST["repassword"]);
    $address = mysqli_real_escape_string($con, $_POST["address"]);

    // Check if password and repassword match
    if ($password !== $repassword) {
        echo "Error: Passwords do not match.";
        exit();
    }

    // Additional validation (you can add more based on your requirements)
    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($repassword) || empty($address)) {
        echo "Error: All fields are required.";
        exit();
    }

    $sql = "INSERT INTO users (fullname, username, email, password, address) VALUES ('$fullname', '$username', '$email', '$password', '$address')";

    if ($con->query($sql) === TRUE) {
        echo "User registered successfully. You can now log in.";
        // Redirect to the login page after successful registration
        header("refresh:3;url=login.php"); // Redirect after 3 seconds
        exit(); // Make sure to exit after the redirect
    } else {
        $error_message = "Error: There was an issue with user registration. Please try again.";
        error_log("Error: " . $sql . "<br>" . $con->error);
    }

    $con->close();
}
?>
<!-- 

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
                <!-- <input type="search" id="q" name="q" placeholder="Search in Daraz" class="search-box__input--O34g" tabindex="1" value=""> 
                <li><a class="active" href="login.php"><i class="bi bi-person"></i></a></li>
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
    </section>

    <section id="register-form">
        <h2>User Registration</h2>
       
    <form action="register.php" method="post">
        <label for="fullname">Fullname</label>
        <input type="text" name="fullname" required><br>

        <label for="username">Username</label>
        <input type="text" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password</label>
        <input type="password" name="password" required><br>

        <label for="repassword">Re-enter Password</label>
        <input type="password" name="repassword" required><br>

        <label for="address">Address</label>
        <input type="text" name="address" required><br>

        <input type="submit" value="Register">
    </form>
</section>

<?php include 'footer.php' ; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->



<?php
// session_start();
// include 'connection.php';

// // Initialize error message variable
// $error_message = '';

// // Check if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $fullname = mysqli_real_escape_string($con, $_POST["fullname"]);
//     $username = mysqli_real_escape_string($con, $_POST["username"]);
//     $email = mysqli_real_escape_string($con, $_POST["email"]);
//     $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
//     $repassword = mysqli_real_escape_string($con, $_POST["repassword"]);
//     $address = mysqli_real_escape_string($con, $_POST["address"]);

//     // Check if password and repassword match
//     if ($password !== $repassword) {
//         $error_message = "Error: Passwords do not match.";
//     } else {
//         // Additional validation (you can add more based on your requirements)
//         if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($repassword) || empty($address)) {
//             $error_message = "Error: All fields are required.";
//         } else {
//             // Check if the username or email is already registered
//             $check_user_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
//             $check_user_result = mysqli_query($con, $check_user_sql);

//             if (mysqli_num_rows($check_user_result) > 0) {
//                 $error_message = "Error: Username or email is already registered. Choose a different one.";
//             } else {
//                 // Insert user data into the database
//                 $insert_sql = "INSERT INTO users (fullname, username, email, password, address) 
//                                VALUES ('$fullname', '$username', '$email', '$password', '$address')";

//                 if ($con->query($insert_sql) === TRUE) {
//                     $_SESSION['registration_success'] = true;
//                     header("Location: login.php");
//                     exit();
//                 } else {
//                     $error_message = "Error: There was an issue with user registration. Please try again.";
//                     error_log("Error: " . $insert_sql . "<br>" . $con->error);
//                 }
//             }
//         }
//     }
// }

// $con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reshmi Optical Center</title>
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
                <li><a class="active" href="login.php"><i class="bi bi-person"></i></a></li>
                <li id="lg-bag"><a href="cart.php"><i class="bi bi-bag-dash"></i></a></li>
                <a href="#" id="close"><i class="bi bi-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="bi bi-bag-dash"></i></a>
            <i id="bar" class="bi bi-list"></i>
        </div>
</section>  

<section id="register-form">
        <h2>User Registration</h2>
        
    <form action="register.php" method="post">
        <label for="fullname">Fullname</label>
        <input type="text" name="fullname" required><br>

        <label for="username">Username</label>
        <input type="text" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password</label>
        <input type="password" name="password" required><br>

        <label for="repassword">Re-enter Password</label>
        <input type="password" name="repassword" required><br>

        <label for="address">Address</label>
        <input type="text" name="address" required><br>

        <input type="submit" value="Register">
    </form>
</section>

<?php include 'footer.php' ; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
