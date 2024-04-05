<?php
session_start();
include '../connection.php';

// Check if the user is logged in
if (!isset($_SESSION['isloggedin']) || $_SESSION['isloggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: ../login.php");
    exit();
}

// Check if the user ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: customers.php");
    exit();
}

$user_id = $_GET['id'];

// Fetch customer information from the database
$customerQuery = "SELECT * FROM users WHERE user_id = ?";
$customerStmt = mysqli_prepare($con, $customerQuery);
mysqli_stmt_bind_param($customerStmt, "i", $user_id);
mysqli_stmt_execute($customerStmt);
$customerResult = mysqli_stmt_get_result($customerStmt);

// Check if customer information is fetched successfully
if ($customerResult && $customer = mysqli_fetch_assoc($customerResult)) {
    // Customer information is available
    // You can use $customer['fullname'], $customer['email'], $customer['phone'] in the form
} else {
    // Customer not found, redirect to the customer list
    header("Location: customers.php");
    exit();
}

// Handle form submission to update customer details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform validation and update operations

    // Assuming you have form fields like $_POST['fullname'], $_POST['email'], $_POST['phone']

    $updateQuery = "UPDATE users SET fullname = ?, username = ?, email = ?, address = ?, phone = ? WHERE user_id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "sssssi", $_POST['fullname'], $_POST['username'], $_POST['email'], $_POST['address'], $_POST['phone'], $user_id);

    if (mysqli_stmt_execute($updateStmt)) {
        // Update successful, redirect to the customer list
        header("Location: customers.php");
        exit();
    } else {
        // Update failed, handle the error or display a message
        echo "Failed to update customer details.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="astyle.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main class='main-content'>
        <a href='customers.php'><i class='bi bi-arrow-left-circle-fill'></i></a>
        <section id='addproduct-form'>
            <div class='title-bar'>
            <h2>Edit Customer</h2>
            </div>
            <form method="post">
                <label for="fullname">FullName:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo $customer['fullname']; ?>" required><br>

                <label for="username">UserName:</label>
                <input type="text" id="username" name="username" value="<?php echo $customer['username']; ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $customer['email']; ?>" required><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $customer['address']; ?>" required><br>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $customer['phone']; ?>" required><br>

                <input class="submit-btn" type="submit" value="Update">
            </form>
        </section>
    </main>
</body>

</html>

<?php
// Close the database connection
mysqli_close($con);
?>