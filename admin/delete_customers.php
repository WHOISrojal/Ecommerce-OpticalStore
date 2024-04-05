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

// Handle customer deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteQuery = "DELETE FROM users WHERE user_id = ?";
    $deleteStmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $user_id);

    if (mysqli_stmt_execute($deleteStmt)) {
        // Deletion successful, redirect to the customer list
        header("Location: customers.php");
        exit();
    } else {
        // Deletion failed, handle the error or display a message
        echo "Failed to delete customer.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h2>Delete Customer</h2>

    <p>Are you sure you want to delete the customer "<?php echo $customer['fullname']; ?>"?</p>

    <form method="post">
        <input type="submit" value="Delete">
    </form>

</body>

</html>

<?php
// Close the database connection
mysqli_close($con);
?>

