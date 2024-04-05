<?php
session_start();
require_once("../db/dbconnect.php");
$pidx = $_GET['pidx'];
$transaction_id = $_GET['transaction_id'];
$amount = $_GET['amount'];
$mobile = $_GET['mobile'];
$purchase_order_id = $_GET['purchase_order_id'];
$purchase_order_name = $_GET['purchase_order_name'];

function verifyPayment($pidx, $conn, $purchase_order_id, $amount, $transaction_id)
{
    $payload = array("pidx" => $pidx);
    $json_payload = json_encode($payload);
    // Initialize cURL
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/lookup/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json_payload,
            CURLOPT_HTTPHEADER => array(
                'Authorization: key 2ab17b262d074d63bc973e9ab5e4d3ef',
                'Content-Type: application/json',
            ),
        )
    );

    // Execute the cURL request
    $response = curl_exec($curl);
    // Close cURL resource
    curl_close($curl);
    verifyPaymentResponse($response, $conn, $purchase_order_id, $amount, $transaction_id);

}

function verifyPaymentResponse($response, $conn, $purchase_order_id, $amount, $transaction_id)
{
    $product_id_exploded = explode(',', $purchase_order_id);
    $product_id_exploded = array_map('intval', $product_id_exploded);
    $response_data = json_decode($response, true);
    $sqlStatus = 'Pending';
    if ($response_data['status'] === "Completed") {
        $sqlStatus = "Completed";
    }
    if ($response_data['status'] === "Pending") {
        $sqlStatus = "Pending";
    }
    if ($response_data['status'] === "Refunded") {
        $sqlStatus = "Refunded";
    }
    if ($response_data['status'] === "Expired") {
        $sqlStatus = "Expired";
    }
    if ($response_data['status'] === "Initiated") {
        $sqlStatus = "Initiated";
    }
    foreach ($product_id_exploded as $product_id) {
        $stmt = $conn->prepare("UPDATE Orders SET status=?, transaction_id=? WHERE product_id=?");
        $stmt->bind_param('ssi', $sqlStatus,$transaction_id, $product_id);
        $stmt->execute();
    }
    // Retrieve product names based on product IDs
    $productIds = explode(',', $purchase_order_id);
    $productNames = array();

    foreach ($productIds as $productId) {
        $stmt = $conn->prepare("SELECT name, price FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $productNames[$row['name']] = $row['price'];
        }
    }
    $receiptNumber = mt_rand(100000, 999999);
    $fullname = $_SESSION['full_name'];
    $email = $_SESSION['email'];
    // Define receipt data
    $receiptData = array(
        "receiptNumber" => "$receiptNumber",
        "orderedBy" => "$fullname",
        "email" => "$email",
        "total" => $amount,
        "paymentMethod" => "Khalti"
    );
        $stmtorder = $conn->prepare("SELECT order_id FROM orders WHERE product_id = ?");
        $stmtorder->bind_param("i", $productId);
        $stmtorder->execute();
        $resultorder = $stmtorder->get_result();
        $getorder= $resultorder->fetch_assoc();
    // Generate receipt HTML
    $receiptHTML = generateReceipt($receiptData, $productNames);
    $stmtreceipt = $conn->prepare("INSERT INTO receipt (user_id, order_id, product_id, customer_email, customer_name, description,transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmtreceipt->bind_param("iisssss", $_SESSION['user_id'],$getorder['order_id'] ,$_GET['purchase_order_id'], $_SESSION['email'], $_SESSION['full_name'], $receiptHTML, $transaction_id);

    // Execute the statement
    $stmtreceipt->execute();

    // Output the receipt HTML
}
function generateReceipt($receiptData, $productNames)
{
    $receiptNumber=mt_rand(100000,999999);
    $html = '<div class="receipt-container">';
    $html .= '<h1 class="mt-4 mb-3">Receipt</h1>';
    $html .= '<div class="row">';
    $html .= '<div class="col">';
    $html .= '<p><strong>Date:</strong> ' . date("Y-m-d H:i:s") . '</p>';
    $html .= '<p><strong>Receipt Number:</strong> #' . $receiptNumber . '</p>';
    $html .= '<p><strong>Ordered By:</strong> #' . $receiptData['orderedBy'] . '</p>';
    $html .= '<p><strong>Email:</strong> #' . $receiptData['email'] . '</p>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<h3 class="mt-4 mb-3">Items:</h3>';
    $html .= '<ul class="list-group mb-3">';

    // Iterate over product names and prices
    foreach ($productNames as $productName => $price) {
        $html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
        $html .= '<div>';
        $html .= '<h6 class="my-0">' . $productName . '</h6>';
        $html .= '<small class="text-muted">Price: Rs.' . $price . '</small>';
        $html .= '</div>';
        $html .= '<span class="text-muted">Rs.' . $price . '</span>';
        $html .= '</li>';
    }

    $html .= '<li class="list-group-item d-flex justify-content-between">';
    $html .= '<span>Total (USD)</span>';
    $html .= '<strong>$' . $receiptData['total'] . '</strong>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '<p><strong>Payment Method:</strong> ' . $receiptData['paymentMethod'] . '</p>';
    $html .= '</div>';

    return $html;
}


function removeFromCart($conn, $purchase_order_id)
{
    $product_id = $purchase_order_id;

    // Check if the user is logged in
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
        // User is logged in, remove the item from the database
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();

        $stmt1 = $conn->prepare("ALTER TABLE cart AUTO_INCREMENT = 1");
        $stmt1->execute();
    }
}
if (isset($pidx)) {
    verifyPayment($pidx, $conn, $purchase_order_id, $amount, $transaction_id);
    removeFromCart($conn, $purchase_order_id);
    header("Location: ../myorders.php");
    exit();
}
?>