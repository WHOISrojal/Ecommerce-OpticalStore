<?php
include 'connection.php';

//Initialize error message variable
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = $_POST["fullname"];
        $username =  $_POST["username"];
        $email =  $_POST["email"];
        $password = $_POST["password"];
        $repassword = $_POST["repassword"];
        $address = $_POST["address"];

        // Check if the username already exists
        $check_username_sql = "SELECT * FROM users WHERE username = ?";
        $check_username_stmt = $con->prepare($check_username_sql);
        $check_username_stmt->bind_param("s", $username);
        $check_username_stmt->execute();
        $check_username_result = $check_username_stmt->get_result();

        if ($check_username_result->num_rows > 0) {
            $error_message = "Username already exists. Please choose a different one.";
        }else{
            if(empty($fullname) || empty($username) || empty($email) || empty($password) || empty($repassword) || empty($address)) {
            // echo "<script>'alert(Please fill in all the fields.)'</script>";
            $error_message = "Please fill in all the fields";
            // exit();
        } elseif ($password !== $repassword) {
            // echo "<script>Passwords do not match.";
            $error_message = "Passwords do not match";
            // exit();
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user if the username is unique
        $insert_user_sql = "INSERT INTO users (fullname, username, email, password, address) VALUES (?,?,?,?,?)";
        $insert_user_stmt = $con->prepare($insert_user_sql);

        if ($insert_user_stmt) {
            $insert_user_stmt->bind_param("sssss", $fullname, $username, $email, $hashedPassword, $address);
            $insert_user_stmt->execute();

        if ($insert_user_stmt->affected_rows > 0) {
            // echo "User registered successfully. You can now log in.";
             // Get the user_id of the registered user
            $user_id = $insert_user_stmt->insert_id;

            // Set session variables after successful registration
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = 'user';

            $success_message = "User registered successfully. You can now log in.";

            // Redirect to the login page after successful registration
            header("refresh:2;url=login.php"); // Redirect after 3 seconds
            exit(); // Make sure to exit after the redirect
        } else {
            $error_message = "Error: There was an issue with user registration. Please try again.";
            error_log("Error: " . $sql . "<br>" . $con->error);
        }
    
        $insert_user_stmt->close();
            }
        }
    }
    $check_username_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

<section id="register-form">
        <h2>User Registration</h2>
        
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

        <form action="register.php" method="post">
        <label for="fullname">Fullname</label>
        <input type="text" name="fullname" required><br>

        <label for="username">Username</label>
        <input type="text" name="username" required><br>

        <label for="email">Email</label>
        <input type="email" name="email" required><br>

        <label for="password">Password</label>
        <input type="password" name="password" required><br>

        <label for="repassword">Confirm Password</label>
        <input type="password" name="repassword" required><br>

        <label for="address">Address</label>
        <input type="text" name="address" required><br>

        <input type="submit" value="Register">
        <a href="login.php">Back to Login Page</a>
    </form>
</section>

<?php include 'footer.php' ; ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>