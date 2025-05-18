<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

// Access token
$access_token = 'fe169949b3984e25a48aa9e89ce28bf0'; // Replace with your own

// Helper function to fetch paginated data
function fetchLoyverseData($url, $access_token, $type) {
    $results = [];
    $offset = 0;
    $limit = 250;
    do {
        $paged_url = $url . "?limit=$limit&offset=$offset";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paged_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $access_token",
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        if (isset($data[$type])) {
            $results = array_merge($results, $data[$type]);
            $offset += $limit;
        } else {
            break;
        }
    } while (count($data[$type]) === $limit);
    return $results;
}

// Fetch metadata
$items = fetchLoyverseData('https://api.loyverse.com/v1.0/items', $access_token, 'items');
$employees = fetchLoyverseData('https://api.loyverse.com/v1.0/employees', $access_token, 'employees');
$stores = fetchLoyverseData('https://api.loyverse.com/v1.0/stores', $access_token, 'stores');

// Map metadata
$item_categories = [];
foreach ($items as $item) {
    $category = $item['category_name'] ?? 'Uncategorized';

    // Map item_id
    if (!empty($item['id'])) {
        $item_categories[$item['id']] = $category;
    }

    // Map variant_id
    if (!empty($item['variants'])) {
        foreach ($item['variants'] as $variant) {
            if (!empty($variant['id'])) {
                $item_categories[$variant['id']] = $category;
            }
        }
    }
}

$employee_names = [];
foreach ($employees as $e) {
    $employee_names[$e['id']] = $e['name'] ?? 'Unknown';
}

$store_names = [];
foreach ($stores as $s) {
    $store_names[$s['id']] = $s['name'] ?? 'Unknown Store';
}

// Fetch receipts
$receipt_data = [];
$receipts_url = 'https://api.loyverse.com/v1.0/receipts';
$params = http_build_query([
    'limit' => 50,
    'created_at_min' => '2025-03-01T00:00:00Z'
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$receipts_url?$params");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $access_token",
    "Content-Type: application/json"
]);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response, true);

if (isset($data['receipts'])) {
    foreach ($data['receipts'] as $receipt) {
        $receipt_number = $receipt['receipt_number'] ?? 'N/A';

        $created_at_raw = $receipt['created_at'] ?? '';
        $date = new DateTime($created_at_raw);
        $created_at = $date->format('Y-m-d H:i');

        $total_money = $receipt['total_money'] ?? 0;
        $employee = $employee_names[$receipt['employee_id']] ?? 'N/A';
        $store = $store_names[$receipt['store_id']] ?? 'N/A';
        $customer = $receipt['customer_id'] ?? 'N/A';

        if (!empty($receipt['line_items'])) {
            foreach ($receipt['line_items'] as $item) {
                $item_name = $item['item_name'] ?? 'Unknown Item';
                $item_id = $item['item_id'] ?? '';
                $variant_id = $item['variant_id'] ?? '';
                $category_key = $variant_id ?: $item_id;
                $item_category = $item_categories[$category_key] ?? 'Uncategorized';

                $quantity = $item['quantity'] ?? 0;
                $item_price = $item['price'] ?? 0;
                $total_item_price = $item['total_money'] ?? ($item_price * $quantity);
                $item_sku = $item['sku'] ?? 'N/A';

                $modifiers = [];
                if (!empty($item['line_modifiers'])) {
                    foreach ($item['line_modifiers'] as $mod) {
                        $modifiers[] = $mod['name'] ?? 'Unnamed Modifier';
                    }
                }

                $taxes = [];
                if (!empty($item['line_taxes'])) {
                    foreach ($item['line_taxes'] as $tax) {
                        $taxes[] = $tax['name'] . ' (' . ($tax['rate'] ?? 0) . '%)';
                    }
                }

                $discounts = [];
                if (!empty($item['line_discounts'])) {
                    foreach ($item['line_discounts'] as $discount) {
                        $discounts[] = $discount['name'] . ' (' . ($discount['amount'] ?? 0) . ')';
                    }
                }

                $receipt_data[] = [
                    'receipt_number' => $receipt_number,
                    'date' => $created_at,
                    'total_price' => $total_money,
                    'item_name' => $item_name,
                    'category' => $item_category,
                    'sku' => $item_sku,
                    'modifiers' => implode(', ', $modifiers) ?: 'None',
                    'taxes' => implode(', ', $taxes) ?: 'None',
                    'discounts' => implode(', ', $discounts) ?: 'None',
                    'quantity' => $quantity,
                    'item_price' => $item_price,
                    'total_item_price' => $total_item_price,
                    'employee' => $employee,
                    'store' => $store,
                    'customer' => $customer,
                ];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Loyverse Receipts Report</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>

<h2>Loyverse Receipts Report</h2>

<table id="receiptsTable" class="display" style="width:100%">
    <thead>
        <tr>
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
        </tr>
    </thead>
    <tbody>
        <?php foreach ($receipt_data as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['receipt_number']) ?></td>
                <td><?= htmlspecialchars($row['date']) ?></td>
                <td><?= htmlspecialchars($row['total_price']) ?></td>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['sku']) ?></td>
                <td><?= htmlspecialchars($row['modifiers']) ?></td>
                <td><?= htmlspecialchars($row['taxes']) ?></td>
                <td><?= htmlspecialchars($row['discounts']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= htmlspecialchars($row['item_price']) ?></td>
                <td><?= htmlspecialchars($row['total_item_price']) ?></td>
                <td><?= htmlspecialchars($row['employee']) ?></td>
                <td><?= htmlspecialchars($row['store']) ?></td>
                <td><?= htmlspecialchars($row['customer']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#receiptsTable').DataTable({
            pageLength: 10,
            order: [[1, 'desc']],
            responsive: true
        });
    });
</script>

</body>
</html>
