<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the Loyverse API endpoint
$api_url = 'https://api.loyverse.com/v1.0/receipts';

// Your Loyverse API Access Token
$access_token = '2a0eda9529444687bccb486d2bf37131';  // Replace with your real token

// Set the parameters for the API request
$params = http_build_query([
    'limit' => 50,  // Maximum number of receipts per request (Max: 250)
    'created_at_min' => '2025-03-01T00:00:00Z',  // Retrieve receipts from this date onward
]);

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$api_url?$params");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json',
]);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
    curl_close($ch);
    exit();
}

// Close cURL
curl_close($ch);

// Decode the JSON response
$data = json_decode($response, true);

// Display the fetched data as a table
if (isset($data['receipts'])) {
    echo "<table border='1'>";
    echo "<tr><th>Receipt Number</th><th>Date</th><th>Total Price</th><th>Items</th></tr>";

    foreach ($data['receipts'] as $receipt) {
        $receipt_number = isset($receipt['number']) ? $receipt['number'] : 'N/A';
        $created_at = isset($receipt['created_at']) ? $receipt['created_at'] : 'N/A';
        $total_price = isset($receipt['total_price']) ? $receipt['total_price'] : '0.00';

        // Check if 'items' array exists and is not empty
        if (isset($receipt['items']) && is_array($receipt['items']) && count($receipt['items']) > 0) {
            $items = array_map(function($item) {
                $item_name = isset($item['name']) ? $item['name'] : 'Unknown Item';
                $quantity = isset($item['quantity']) ? $item['quantity'] : '0';
                $price = isset($item['price']) ? $item['price'] : '0.00';
                return "{$item_name} (Qty: {$quantity}, Price: {$price})";
            }, $receipt['items']);

            $items_display = implode('<br>', $items);
        } else {
            $items_display = "No items found for this receipt.";
        }

        echo "<tr>";
        echo "<td>{$receipt_number}</td>";
        echo "<td>{$created_at}</td>";
        echo "<td>{$total_price}</td>";
        echo "<td>$items_display</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No sales data found or an error occurred.";
}

?>
