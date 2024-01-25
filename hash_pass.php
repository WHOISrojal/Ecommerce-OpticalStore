<?php
include 'connection.php';
$username = 'admin';
$password = 'admin';

// Hash the admin password
$hashed_admin_password = password_hash($password, PASSWORD_DEFAULT);

// Display the hashed admin password
// echo "Admin Username: $admin_username<br>";
echo "Hashed Admin Password: $hashed_admin_password";
?>

<!-- SQL QUERY TO UPDATE HASH PASSWORD -->
<!-- UPDATE your_table_name
SET password = 'new_hashed_password'
WHERE username = 'specific_username'; -->



<?php
// include'connection.php';
// $username = 'admin';
// $password = 'admin';

// // Hash the admin password
// $hashed_admin_password = password_hash($password, PASSWORD_DEFAULT);

// // Check if the admin user already exists
// $sql = "SELECT * FROM users WHERE username=?";
// $stmt = mysqli_prepare($con, $sql);

// if ($stmt) {
//     mysqli_stmt_bind_param($stmt, "s", $username);
//     mysqli_stmt_execute($stmt);

//     $result = mysqli_stmt_get_result($stmt);

//     if (mysqli_num_rows($result) == 0) {
//         // Admin user doesn't exist, insert it into the database
//         $insert_sql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";
//         $insert_stmt = mysqli_prepare($con, $insert_sql);

//         if ($insert_stmt) {
//             $user_type = 'admin';
//             mysqli_stmt_bind_param($insert_stmt, "sss", $username, $hashed_admin_password, $user_type);
//             mysqli_stmt_execute($insert_stmt);

//             mysqli_stmt_close($insert_stmt);
//             echo "Admin user created successfully.";
//         } else {
//             echo "Error creating admin user: " . mysqli_error($con);
//         }
//     } else {
//         echo "Admin user already exists.";
//     }

//     mysqli_stmt_close($stmt);
// } else {
//     echo "Error checking admin user: " . mysqli_error($con);
// }

// mysqli_close($con);
?>


