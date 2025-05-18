<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

// Access token
$access_token = 'fe169949b3984e25a48aa9e89ce28bf0'; // Replace with your real token

// Fetch categories from Loyverse API
function fetchLoyverseCategories($access_token) {
    $url = 'https://api.loyverse.com/v1.0/categories';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '?limit=250');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    return $data['categories'] ?? [];
}

$categories = fetchLoyverseCategories($access_token);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Loyverse Item Categories</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>

<h2>Loyverse Item Categories</h2>

<table id="categoriesTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Name</th>
            <th>Color</th>
            <th>Created At</th>
            <th>Deleted</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category['id']) ?></td>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td><?= htmlspecialchars($category['color']) ?></td>
                <td><?= (new DateTime($category['created_at']))->format('Y-m-d H:i') ?></td>
                <td><?= isset($category['deleted_at']) && $category['deleted_at'] ? 'Yes' : 'No' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#categoriesTable').DataTable({
            pageLength: 20,
            order: [[1, 'asc']],
            responsive: true
        });
    });
</script>

</body>
</html>
