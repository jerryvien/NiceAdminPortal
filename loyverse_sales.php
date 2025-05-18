<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the Loyverse API endpoint
$api_url = 'https://api.loyverse.com/v1.0/receipts';

// Your Loyverse API Access Token
$access_token = 'fe169949b3984e25a48aa9e89ce28bf0';  // Replace with your real token

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

// Display raw response for debugging
echo "<pre>";
print_r($data);
echo "</pre>";

// Display the fetched data as a table
if (isset($data['receipts'])) {
    echo "<table border='1'>";
    echo "<tr>
        <th>Receipt ID</th>
        <th>Receipt Number</th>
        <th>Date</th>
        <th>Total Price</th>
        <th>Item Name</th>
        <th>Category</th>
        <th>SKU</th>
        <th>Modifiers</th>
        <th>Taxes</th>
        <th>Discounts</th>
        <th>Quantity</th>
        <th>Item Price</th>
        <th>Total Item Price</th>
        <th>Employee</th>
        <th>Store</th>
        <th>Customer</th>
    </tr>";

    foreach ($data['receipts'] as $receipt) {
        $receipt_id = $receipt['id'] ?? 'N/A';
        $receipt_number = $receipt['number'] ?? 'N/A';
        $created_at = $receipt['created_at'] ?? 'N/A';
        $total_price = $receipt['total_price'] ?? '0.00';
        $employee = $receipt['employee_name'] ?? 'N/A';
        $store = $receipt['store_id'] ?? 'N/A';
        $customer = $receipt['customer_name'] ?? 'N/A';

        if (isset($receipt['line_items']) && is_array($receipt['line_items'])) {
            foreach ($receipt['line_items'] as $item) {
                $item_name = $item['name'] ?? 'Unknown Item';
                $item_category = $item['category_name'] ?? 'Unknown Category';
                $quantity = $item['quantity'] ?? '0';
                $item_price = $item['price'] ?? '0.00';
                $total_item_price = $quantity * $item_price;
                $item_sku = $item['sku'] ?? 'N/A';

                // Handle Modifiers
                $modifiers = [];
                if (isset($item['modifiers']) && is_array($item['modifiers'])) {
                    foreach ($item['modifiers'] as $modifier) {
                        $modifiers[] = $modifier['name'];
                    }
                }
                $modifiers_display = implode(', ', $modifiers) ?: 'None';

                // Handle Taxes
                $taxes = [];
                if (isset($item['taxes']) && is_array($item['taxes'])) {
                    foreach ($item['taxes'] as $tax) {
                        $taxes[] = $tax['name'] . ' (' . $tax['rate'] . '%)';
                    }
                }
                $tax_display = implode(', ', $taxes) ?: 'None';

                // Handle Discounts
                $discounts = [];
                if (isset($item['discounts']) && is_array($item['discounts'])) {
                    foreach ($item['discounts'] as $discount) {
                        $discounts[] = $discount['name'] . ' (' . $discount['amount'] . ')';
                    }
                }
                $discount_display = implode(', ', $discounts) ?: 'None';

                echo "<tr>";
                echo "<td>{$receipt_id}</td>";
                echo "<td>{$receipt_number}</td>";
                echo "<td>{$created_at}</td>";
                echo "<td>{$total_price}</td>";
                echo "<td>{$item_name}</td>";
                echo "<td>{$item_category}</td>";
                echo "<td>{$item_sku}</td>";
                echo "<td>{$modifiers_display}</td>";
                echo "<td>{$tax_display}</td>";
                echo "<td>{$discount_display}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>{$item_price}</td>";
                echo "<td>{$total_item_price}</td>";
                echo "<td>{$employee}</td>";
                echo "<td>{$store}</td>";
                echo "<td>{$customer}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='16'>No items found for this receipt.</td></tr>";
        }
    }
    echo "</table>";
} else {
    echo "No sales data found or an error occurred.";
}

?>
