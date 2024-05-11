<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['isloggedin']) || $_SESSION['isloggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Fetch customer information from the database
$customerQuery = "SELECT fullname, email, phone FROM users WHERE user_id = ?";
$customerStmt = mysqli_prepare($con, $customerQuery);
mysqli_stmt_bind_param($customerStmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($customerStmt);
$customerResult = mysqli_stmt_get_result($customerStmt);

// Check if customer information is fetched successfully
if ($customerResult && $customer = mysqli_fetch_assoc($customerResult)) {
    // Use fetched customer information in the payload
    $customerInfo = [
        'name' => $customer['fullname'],
        'email' => $customer['email'],
        'phone' => $customer['phone']
    ];
} else {
    // Log the error
    error_log("Failed to fetch customer information from the database");

    // Display a user-friendly error message
    die("An unexpected error occurred. Please try again later.");
}

// Check if the total amount is provided in the URL
$totalAmount = isset($_GET['total']) ? (float)$_GET['total'] : 0;
// Generate a unique purchase_order_id
$purchaseOrderId = uniqid('order_');

// Initialize variables for API credentials
$apiEndpoint = 'https://a.khalti.com/api/v2/epayment/initiate/';
$secretKey = 'b0ce52de04c647f2a81b300118150aa8';

// Fetch cart items from the database for the payment details
$cartQuery = "SELECT cart.id, cart.quantity, products.name, products.price 
              FROM cart 
              JOIN products ON cart.product_id = products.id 
              WHERE cart.user_id = ?";
$cartStmt = mysqli_prepare($con, $cartQuery);
mysqli_stmt_bind_param($cartStmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($cartStmt);
$cartResult = mysqli_stmt_get_result($cartStmt);

// Check if cart items are fetched successfully
if ($cartResult) {
    $cartItems = mysqli_fetch_all($cartResult, MYSQLI_ASSOC);
    $product_id = $cartItems[0]['id'];
} else {
    // Log the error
    error_log("Failed to fetch cart items from the database");

    // Display a user-friendly error message
    die("An unexpected error occurred. Please try again later.");
}

// Prepare the JSON payload for Khalti initiation
$payload = [
    'return_url' => 'https://localhost/Projects/payment_callback.php', // Replace with your actual return URL
    'website_url' => 'http://localhost/Projects/', // Replace with your actual website URL
    'amount' => $totalAmount * 100, // Convert amount to paisa
    'purchase_order_id' => $product_id,
    'purchase_order_name' => 'Test', // Replace with an appropriate purchase order name
    'customer_info' => $customerInfo, //Fetched customer information
    'amount_breakdown' => [
        [
            'label' => 'Total Amount',
            'amount' => $totalAmount * 100, // Convert amount to paisa
        ],
    ],
    'product_details' => [],
];

// Add cart item details to the payload
foreach ($cartItems as $cartItem) {
    $payload['product_details'][] = [
        'identity' => $cartItem['id'],
        'name' => $cartItem['name'],
        'total_price' => $cartItem['price'] * 100, // Convert price to paisa
        'quantity' => $cartItem['quantity'],
        'unit_price' => $cartItem['price'] * 100, // Convert price to paisa
    ];
}

// Convert the payload to JSON
$jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE);

// Set up cURL to initiate the payment
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiEndpoint,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $jsonPayload,
    CURLOPT_HTTPHEADER => [
        'Authorization: key ' . $secretKey,
        'Content-Type: application/json',
    ],
]);

// Execute cURL and get the response
$response = curl_exec($curl);

// Check if cURL request was successful
if ($response === false) {
    echo "cURL Error: " . curl_error($curl);
}else {
    // Output the Khalti API response
    // echo $response;
    $responseData = json_decode($response, true);
    echo "Khalti API Response: <pre>" . print_r($responseData, true) . "</pre>";
    
    // Check if payment_url is present in the response
    if (isset($responseData['payment_url'])) {
        // Extract the payment URL
        $khaltiPaymentURL = $responseData['payment_url'];

        // Redirect user to Khalti's payment page
        // error_log("Success - " . print_r($responseData, true));
        header("Location: $khaltiPaymentURL");
        exit();
    } else {
        // Log the error for further investigation
        error_log("Error: Payment URL not found in Khalti API response - " . print_r($responseData, true));
        echo "Error: Payment URL not found in Khalti API response";
    }
}

// Close cURL
curl_close($curl);

// Close the database connection
mysqli_close($con);

?>