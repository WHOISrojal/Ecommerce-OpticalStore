<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert data into the database
    $query = "INSERT INTO feedback (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $subject, $message);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Optionally, you can redirect the user to a thank you page
        // header('Location: .php');
        echo '<script>alert("Thankyou for sharing your views"); window.location.href="contact.php";</script>'; 
        exit();
    } else {
        // Handle database insertion error
        echo "Error: " . mysqli_error($con);
    }
}
mysqli_close($con);
?>

