<?php
// loyverse_sales.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kuala_Lumpur');

require_once 'loyverse_helpers.php';

$access_token = 'fe169949b3984e25a48aa9e89ce28bf0'; // replace with your token

$category_map = getCategoryMap($access_token);
$item_categories = getItemCategoryMap($access_token, $category_map);
$employee_map = getEmployeeMap($access_token);
$store_map = getStoreMap($access_token);
$receipts = fetchReceipts($access_token);

$receipt_data = [];
$category_totals = [];

foreach ($receipts as $receipt) {
    $receipt_number = $receipt['receipt_number'] ?? 'N/A';
    $created_at = isset($receipt['created_at']) ? (new DateTime($receipt['created_at']))->format('Y-m-d H:i') : 'N/A';
    $employee = $employee_map[$receipt['employee_id']] ?? 'N/A';
    $store = $store_map[$receipt['store_id']] ?? 'N/A';
    $customer = $receipt['customer_id'] ?? 'N/A';

    foreach ($receipt['line_items'] ?? [] as $item) {
        $id = $item['variant_id'] ?? $item['item_id'] ?? '';
        $category = $item_categories[$id] ?? 'Uncategorized';
        $quantity = $item['quantity'] ?? 0;
        $price = $item['price'] ?? 0;
        $total = $item['total_money'] ?? ($quantity * $price);
        $category_totals[$category] = ($category_totals[$category] ?? 0) + $total;

        $receipt_data[] = [
            'receipt_number' => $receipt_number,
            'date' => $created_at,
            'category' => $category,
            'item_name' => $item['item_name'] ?? 'Unknown',
            'quantity' => $quantity,
            'sku' => $item['sku'] ?? 'N/A',
            'total' => $total,
            'employee' => $employee,
            'store' => $store,
            'customer' => $customer
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Loyverse Sales Report</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Loyverse Sales by Category</h2>

<canvas id="categoryChart" height="100"></canvas>
<script>
const ctx = document.getElementById('categoryChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($category_totals)) ?>,
        datasets: [{
            label: 'Sales Total (MYR)',
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

<table id="salesTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Receipt</th>
            <th>Date</th>
            <th>Category</th>
            <th>Item</th>
            <th>Qty</th>
            <th>SKU</th>
            <th>Total (MYR)</th>
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
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td><?= htmlspecialchars($row['item_name']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td><?= htmlspecialchars($row['sku']) ?></td>
            <td><?= number_format($row['total'], 2) ?></td>
            <td><?= htmlspecialchars($row['employee']) ?></td>
            <td><?= htmlspecialchars($row['store']) ?></td>
            <td><?= htmlspecialchars($row['customer']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <?php foreach ($category_totals as $cat => $total): ?>
        <tr>
            <td colspan="2"><strong>Total for <?= htmlspecialchars($cat) ?>:</strong></td>
            <td colspan="8"><strong><?= number_format($total, 2) ?> MYR</strong></td>
        </tr>
        <?php endforeach; ?>
    </tfoot>
</table>

<script>
$(document).ready(function() {
    $('#salesTable').DataTable({
        pageLength: 10,
        order: [[1, 'desc']]
    });
});
</script>

</body>
</html>
