<!-- SQL QUERIES FOR ALL TABLES -->
<!-- ---------------------------------------------------------------------------------------------------- -->
<!-- CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->

<!-- CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    user_type ENUM('user', 'admin') NOT NULL,
    phone VARCHAR(15) UNIQUE
); -->

<!-- CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    quantity INT,
    user_id INT,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
); -->

<!-- CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->

<!-- This SQL is for starting the number from 1
SET @row_number = 0;
UPDATE users
SET user_id = (@row_number:=@row_number+1)
ORDER BY user_id;

arko 

ALTER TABLE tablename AUTO_INCREMENT = 1; -->


<!-- CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    product_id INT,
    total_amount DECIMAL(10, 2),
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    transaction_id varchar(255),
    FOREIGN KEY (customer_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(id)
); -->

<!-- CREATE TABLE receipt (
    receipt_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_id INT,
    product_id INT,
    customer_email VARCHAR(255),
    customer_name VARCHAR(255),
    description TEXT,
    transaction_id VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (transaction_id) REFERENCES orders(transaction_id),
    FOREIGN KEY (product_id) REFERENCES products(id)

    after that to delete from order use this:
    
    ALTER TABLE receipt
    ADD CONSTRAINT fk_order_id FOREIGN KEY (order_id)
    REFERENCES orders(order_id)
    ON DELETE CASCADE;
); -->



<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $categoryName = $_POST["category_name"];

    // Image handling
    $targetDir = "../image/uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $targetPath = "image/uploads/" . basename($_FILES["image"]["name"]);
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
    // Check if image file is a actual image or fake image
    // $check = getimagesize($_FILES["image"]["tmp_name"]);
    // if ($check === false) {
    //     echo "File is not an image.";
    //     $uploadOk = 0;
    // }

    // Check if file already exists
    // if (file_exists($targetFile)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }

    // Check file size
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    //     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //     $uploadOk = 0;
    // }ilo
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO products (name, description, price, image, category_name) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssdss", $name, $description, $price, $targetPath, $categoryName);
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
    <link rel="stylesheet" href="astyle.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
    <a href='admin_dashboard.php'><i class='bi bi-arrow-left-circle-fill'></i></a>
    <section id="addproduct-form">
        <div class="title-bar">
        <h2>Add Products</h2>
        </div>
        <form action="add_products.php" method="post" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" placeholder="Product" required><br>

            <label for="description">Product Description:</label>
            <textarea id="description" name="description" placeholder="Details" required></textarea><br>

            <label for="price">Product Price:</label>
            <input type="number" id="price" name="price" placeholder="Price" required><br>

            <label for="category">Category:</label>
            <select id="category" name="category_name" required>
                <option value="eyeglasses">Eyeglasses</option>
                <option value="sunglasses">Sunglasses</option>
                <option value="lenses">Lenses</option>
            </select><br><br>
            
            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <input class="submit-btn" type="submit" value="Add Product">
        </form>
    </section>
</main>
</body>
</html>