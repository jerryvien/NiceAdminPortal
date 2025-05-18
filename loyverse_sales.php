<?php
// SETUP
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kuala_Lumpur');

$access_token = 'fe169949b3984e25a48aa9e89ce28bf0'; // Replace with yours

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

// FETCH DATA
$items = fetchLoyverseData('https://api.loyverse.com/v1.0/items', $access_token, 'items');
$employees = fetchLoyverseData('https://api.loyverse.com/v1.0/employees', $access_token, 'employees');
$stores = fetchLoyverseData('https://api.loyverse.com/v1.0/stores', $access_token, 'stores');
$categories = fetchLoyverseData('https://api.loyverse.com/v1.0/categories', $access_token, 'categories');

// MAP DATA
$category_map = [];
foreach ($categories as $cat) {
    $category_map[$cat['id']] = $cat['name'];
}

$item_categories = [];
foreach ($items as $item) {
    $cat_id = $item['category_id'] ?? null;
    $cat_name = $category_map[$cat_id] ?? 'Uncategorized';
    $item_categories[$item['id']] = $cat_name;
    if (!empty($item['variants'])) {
        foreach ($item['variants'] as $variant) {
            $item_categories[$variant['id']] = $cat_name;
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

// FETCH RECEIPTS
$receipt_data = [];
$category_totals = [];

$receipts_url = 'https://api.loyverse.com/v1.0/receipts';
$params = http_build_query(['limit' => 50, 'created_at_min' => '2025-03-01T00:00:00Z']);

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
        $created_at = (new DateTime($receipt['created_at'] ?? ''))->format('Y-m-d H:i');
        $total_money = $receipt['total_money'] ?? 0;
        $employee = $employee_names[$receipt['employee_id']] ?? 'N/A';
        $store = $store_names[$receipt['store_id']] ?? 'N/A';
        $customer = $receipt['customer_id'] ?? 'N/A';

        if (!empty($receipt['line_items'])) {
            foreach ($receipt['line_items'] as $item) {
                $item_name = $item['item_name'] ?? 'Unknown Item';
                $variant_id = $item['variant_id'] ?? '';
                $item_id = $item['item_id'] ?? '';
                $id_key = $variant_id ?: $item_id;
                $item_category = $item_categories[$id_key] ?? 'Uncategorized';

                $quantity = $item['quantity'] ?? 0;
                $item_price = $item['price'] ?? 0;
                $total_item_price = $item['total_money'] ?? ($item_price * $quantity);
                $item_sku = $item['sku'] ?? 'N/A';

                $modifiers = array_map(fn($m) => $m['name'] ?? '', $item['line_modifiers'] ?? []);
                $taxes = array_map(fn($t) => $t['name'] . ' (' . ($t['rate'] ?? 0) . '%)', $item['line_taxes'] ?? []);
                $discounts = array_map(fn($d) => $d['name'] . ' (' . ($d['amount'] ?? 0) . ')', $item['line_discounts'] ?? []);

                // Store data
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

                // Sum category sales
                $category_totals[$item_category] = ($category_totals[$item_category] ?? 0) + $total_item_price;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Loyverse Sales Report</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Loyverse Receipts Report</h2>

<canvas id="categoryChart" height="100"></canvas>

<script>
    const ctx = document.getElementById('categoryChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($category_totals)) ?>,
            datasets: [{
                label: 'Total Sales by Category (MYR)',
                data: <?= json_encode(array_values($category_totals)) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

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
    <tfoot>
        <?php foreach ($category_totals as $cat => $total): ?>
            <tr>
                <td colspan="4"><strong>Total for <?= htmlspecialchars($cat) ?>:</strong></td>
                <td colspan="11"><strong><?= number_format($total, 2) ?> MYR</strong></td>
            </tr>
        <?php endforeach; ?>
    </tfoot>
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
