<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kuala_Lumpur');

require_once 'loyverse_helpers.php';

$access_token = 'your_token_here';

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
