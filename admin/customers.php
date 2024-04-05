<?php
session_start();
include '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="astyle.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
</body>
</html>


<?php

if (!isset($_SESSION['username']) || ($_SESSION['user_type'] !== 'admin' && !$_SESSION['isloggedin'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch items from the users table where user_type is 'user'
$userQuery = "SELECT user_id, username, fullname, email, address, phone FROM users WHERE user_type = 'user'";
$userResult = mysqli_query($con, $userQuery);

// Check if the query was successful
if ($userResult) {
    // Start the table
    echo '<main class="main-content">';
    echo '<section class="customer-title">';
    echo '<h2 class="customer-tag">Customers</h2>';
    echo '<table class="table table-bordered table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>User ID</th>';
    echo '<th>Username</th>';
    echo '<th>Fullname</th>';
    echo '<th>Email</th>';
    echo '<th>Address</th>';
    echo '<th>Phone</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '</section>';
    echo '</main>';


    // Fetch and display user details in table rows
    while ($user = mysqli_fetch_assoc($userResult)) {
        echo '<tr>';
        echo '<td>' . $user['user_id'] . '</td>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>' . $user['fullname'] . '</td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td>' . $user['address'] . '</td>';
        echo '<td>' . $user['phone'] . '</td>';
        echo "<td>";
        echo "<a href='edit_customers.php?id={$user['user_id']}'>Edit</a> | ";
        echo "<a href='delete_customers.php?id={$user['user_id']}'>Delete</a>";
        echo "</td>";
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    // Handle the query error
    echo "Error fetching users: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>



<!-- // Fetch user details from the database
// $userQuery = "SELECT * FROM users WHERE user_id = ?";
// $userStmt = mysqli_prepare($con, $userQuery);
// mysqli_stmt_bind_param($userStmt, "i", $user_id);
// mysqli_stmt_execute($userStmt);
// $userResult = mysqli_stmt_get_result($userStmt);

// if ($userResult && $userData = mysqli_fetch_assoc($userResult)) {
//     // User details
//     $fullname = $userData['fullname'];
//     $username = $userData['username'];
//     $email = $userData['email'];
//     $address = $userData['address'];

//     // Display user details
//     echo "<h2>User Details</h2>";
//     echo "<p>Full Name: $fullname</p>";
//     echo "<p>Username: $username</p>";
//     echo "<p>Email: $email</p>";
//     echo "<p>Address: $address</p>";
// } else {
//     echo "User not found or an error occurred.";
// }

// mysqli_close($con); -->