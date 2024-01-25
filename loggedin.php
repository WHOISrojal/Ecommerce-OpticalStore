<?php
// session_start();

// // Check if the user is logged in
// if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'user') {
//     $user_id = $_SESSION['user_id'];
//     $user_type = $_SESSION['user_type'];

//     // Fetch user information from the database based on $user_id
//     $sql = "SELECT * FROM users WHERE user_id = $user_id";
//     $result = $con->query($sql);

//     if ($result->num_rows > 0) {
//         $user = $result->fetch_assoc();

//         // Now $user contains information about the logged-in user
//         $username = $user['username'];
//         $fullname = $user['fullname'];

//         // Display the user information
//         echo "Welcome, $fullname ($username)!";
//     } else {
//         echo "Error fetching user information.";
//     }
// } else {
//     echo "Welcome, Guest!";
// }
?>

<?php
// session_start();

// Check if the user is logged in
// if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
//     $user_id = $_SESSION['user_id'];
//     $user_type = $_SESSION['user_type'];

//     // Query the database to get additional user details (adjust this query based on your database structure)
//     $sql = "SELECT * FROM users WHERE user_id = ?";
//     $stmt = mysqli_prepare($con, $sql);

//     if ($stmt) {
//         mysqli_stmt_bind_param($stmt, "i", $user_id);
//         mysqli_stmt_execute($stmt);

//         $result = mysqli_stmt_get_result($stmt);

//         if ($result) {
//             $user_details = mysqli_fetch_assoc($result);

//             // Now you can use $user_details to display user information
//             echo "Welcome, " . $user_details['username'] . "!";

//             // Additional details based on your database structure
//             echo "Email: " . $user_details['email'];
//             echo "Address: " . $user_details['address'];

//             // ... and so on
//         }

//         // Close the statement
//         mysqli_stmt_close($stmt);
//     }
// } else {
//     // User is not logged in, show login/register links or other content
//     echo "Welcome, Guest! <a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
// }
?>


<?php 

include 'connection.php';

// Initialize the welcome message variable
$welcomeMessage = '';

// Check if the user is logged in
if (isset($_SESSION['username']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'user') {
    // Fetch additional user details based on your database structure
    $username = $_SESSION['username'];
    // $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $user_details = mysqli_fetch_assoc($result);

            // Display welcome message
            // echo "Welcome, " . $user_details['username'] . "!";
            $welcomeMessage = "$username <a href='logout.php'>Logout</a>";
            echo "<p style='color: red;'>$welcomeMessage</p>";
            // echo "Welcome, $username! <a href='logout.php'>Logout</a>";
            // ... (display additional user details if needed)
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
} else {
    // User is not logged in, display other content
    // echo "Welcome, Guest!";
    $welcomeMessage = "Guest";
    echo "<p style='color:gray ;'>$welcomeMessage</p>";
}
?>


