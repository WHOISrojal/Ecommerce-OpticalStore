<?php
// Include necessary files and configurations
session_start();
include 'connection.php';

// Verify the authenticity of the callback (For illustration purposes, you might need to check signatures or tokens provided by Khalti)

// Process Khalti callback data
$pidx = isset($_GET['pidx']) ? $_GET['pidx'] : '';
$txnId = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
$amount = isset($_GET['amount']) ? $_GET['amount'] : '';
$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
$purchaseOrderId = isset($_GET['purchase_order_id']) ? $_GET['purchase_order_id'] : '';
$purchaseOrderName = isset($_GET['purchase_order_name']) ? $_GET['purchase_order_name'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

function verifyPayment($pidx, $con, $purchaseOrderId, $amount, $txnId, $purchaseOrderName)
{
    $secretKey = 'b0ce52de04c647f2a81b300118150aa8';
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
                'Authorization: key ' . $secretKey,
                'Content-Type: application/json',
            ),
        )
    );

    // Execute the cURL request
    $response = curl_exec($curl);

    // Check for cURL errors
    if ($response === false) {
        error_log("cURL Error: " . curl_error($curl));
        die("cURL Error: " . curl_error($curl));
    }

    // Close cURL resource
    curl_close($curl);

    verifyPaymentResponse($response, $con, $purchaseOrderId, $amount, $txnId, $purchaseOrderName);
}

function verifyPaymentResponse($response, $con, $purchaseOrderId, $amount, $txnId, $purchaseOrderName)
{
    $product_id_exploded = explode(',', $purchaseOrderId);
    $product_id_exploded = array_map('intval', $product_id_exploded);
    $response_data = json_decode($response, true);
    $sqlStatus = 'Pending';

    // foreach ($product_id_exploded as $product_id) {
    //     // Sanitize input to prevent SQL injection
    //     $sqlStatus = $con->real_escape_string($sqlStatus);
    //     $transaction_id = $con->real_escape_string($txnId);
    //     $product_id = intval($product_id);

    $stmtDisable = $con->prepare("SET FOREIGN_KEY_CHECKS = 0");
    $stmtDisable->execute();
    $stmt = $con->prepare("INSERT INTO orders (customer_id, product_id, total_amount, payment_status, transaction_id) VALUES (?, ?, ?, 'completed', ?)");
    $stmt->bind_param('iids', $_SESSION['user_id'], $purchaseOrderId, $amount, $txnId);
    if ($stmt->execute()) {
        // $sel= $con->prepare("SELECT order_id FROM orders WHERE transaction_id=?");
        // $sel->bind_param('i',$txnId);
        // $res=$sel->get_result();
        // $getorder=$res->fetch_assoc();
        $lastInsertId = $con->insert_id;
        echo $lastInsertId;
        $cart = $con->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
        $cart->bind_param("ii", $_SESSION['user_id'], $purchaseOrderId);
        $cart->execute();
        $receiptHTML = generateReceipt($amount, $purchaseOrderName);
        $stmtreceipt = $con->prepare("INSERT INTO receipt (user_id, order_id, product_id, customer_email, customer_name, description,transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtreceipt->bind_param("iisssss", $_SESSION['user_id'], $lastInsertId, $purchaseOrderId, $_SESSION['email'], $_SESSION['fullname'], $receiptHTML, $txnId);
        $stmtreceipt->execute();
        $stmtDisable = $con->prepare("SET FOREIGN_KEY_CHECKS = 1");
        $stmtDisable->execute();
        header('Location: index.php');
        exit();
    }
    // }
}

function generateReceipt($amount, $purchaseOrderName)
{
    $receiptNumber = mt_rand(100000, 999999);
    $html = '<div class="receipt-container">';
    $html .= '<h1 class="mt-4 mb-3">Receipt</h1>';
    $html .= '<div class="row">';
    $html .= '<div class="col">';
    $html .= '<p><strong>Date:</strong> ' . date("Y-m-d H:i:s") . '</p>';
    $html .= '<p><strong>Receipt Number:</strong> #' . $receiptNumber . '</p>';
    $html .= '<p><strong>Ordered By:</strong> #' . $_SESSION['fullname'] . '</p>';
    $html .= '<p><strong>Email:</strong> #' . $_SESSION['email'] . '</p>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<h3 class="mt-4 mb-3">Items:</h3>';
    $html .= '<ul class="list-group mb-3">';


    $html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
    $html .= '<div>';
    $html .= '<h6 class="my-0">' . $purchaseOrderName . '</h6>';
    $html .= '<small class="text-muted">Price: Rs.' . $amount . '</small>';
    $html .= '</div>';
    $html .= '<span class="text-muted">Rs.' . $amount . '</span>';
    $html .= '</li>';

    $html .= '<li class="list-group-item d-flex justify-content-between">';
    $html .= '<span>Total (NPR)</span>';
    $html .= '<strong>Rs. ' . $amount . '</strong>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '<p><strong>Payment Method:</strong>Khalti</p>';
    $html .= '</div>';

    return $html;
}

// Call the function to verify and process payment
verifyPayment($pidx, $con, $purchaseOrderId, $amount, $txnId, $purchaseOrderName);
