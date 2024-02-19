<?php
// include 'connection.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST["name"];
//     $description = $_POST["description"];
//     $price = $_POST["price"];

//     $sql = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";
//     $stmt = mysqli_prepare($con, $sql);

//     if ($stmt) {
//         mysqli_stmt_bind_param($stmt, "ssd", $name, $description, $price);
//         mysqli_stmt_execute($stmt);
//         mysqli_stmt_close($stmt);
//         echo "Product added successfully!";
//     } else {
//         echo "Error: " . mysqli_error($con);
//     }
// }

// mysqli_close($con);
?>

<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Image handling
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssds", $name, $description, $price, $targetFile);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "Product added successfully!";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form action="add_products.php" method="post">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="description">Product Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Product Price:</label>
        <input type="number" id="price" name="price" step="0.01" required><br>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html>