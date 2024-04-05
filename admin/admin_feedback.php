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

// Fetch feedback data from the database
$query = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

// Check if there is any feedback data
if ($result) {
    echo '<main class="main-content">';
    echo '<section class="customer-title">';
    echo '<h2 class="customer-tag">Feedback</h2>';
    echo '<table class="table table-bordered table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo "<th>Id</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Subject</th>";
    echo "<th>Message</th>";
    echo "<th>Created At</th>";
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '</section>';
    echo '</main>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['subject'] . '</td>';
        echo '<td>' . $row['message'] . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    mysqli_free_result($result);
} else {
    // Handle error if needed
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>