<?php
// loyverse_helpers.php (revised with logging)

function fetchLoyverseData($url, $access_token, $type) {
    $results = [];
    $offset = 0;
    $limit = 250;
    do {
        $paged_url = "$url?limit=$limit&offset=$offset";
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
            error_log("Failed to fetch or decode $type data from $url");
            break;
        }
    } while (count($data[$type] ?? []) === $limit);
    return $results;
}

function getCategoryMap($access_token) {
    $categories = fetchLoyverseData('https://api.loyverse.com/v1.0/categories', $access_token, 'categories');
    $map = [];
    foreach ($categories as $cat) {
        if (isset($cat['id'], $cat['name'])) {
            $map[$cat['id']] = $cat['name'];
        } else {
            error_log("Category missing ID or name: " . json_encode($cat));
        }
    }
    return $map;
}

function getItemCategoryMap($access_token, $category_map) {
    $items = fetchLoyverseData('https://api.loyverse.com/v1.0/items', $access_token, 'items');
    $map = [];
    foreach ($items as $item) {
        $cat_id = $item['category_id'] ?? null;
        if (!$cat_id) {
            error_log("Item {$item['id']} missing category_id");
        }
        $cat_name = $category_map[$cat_id] ?? 'Uncategorized';

        if (!empty($item['id'])) {
            $map[$item['id']] = $cat_name;
        }

        if (!empty($item['variants'])) {
            foreach ($item['variants'] as $variant) {
                if (!empty($variant['id'])) {
                    $map[$variant['id']] = $cat_name;
                } else {
                    error_log("Variant missing ID in item {$item['id']}");
                }
            }
        }
    }
    return $map;
}

function getEmployeeMap($access_token) {
    $employees = fetchLoyverseData('https://api.loyverse.com/v1.0/employees', $access_token, 'employees');
    $map = [];
    foreach ($employees as $e) {
        if (isset($e['id'], $e['name'])) {
            $map[$e['id']] = $e['name'];
        } else {
            error_log("Employee record missing ID or name: " . json_encode($e));
        }
    }
    return $map;
}

function getStoreMap($access_token) {
    $stores = fetchLoyverseData('https://api.loyverse.com/v1.0/stores', $access_token, 'stores');
    $map = [];
    foreach ($stores as $s) {
        if (isset($s['id'], $s['name'])) {
            $map[$s['id']] = $s['name'];
        } else {
            error_log("Store record missing ID or name: " . json_encode($s));
        }
    }
    return $map;
}

function fetchReceipts($access_token, $created_after = '2025-03-01T00:00:00Z') {
    $url = 'https://api.loyverse.com/v1.0/receipts';
    $params = http_build_query(['limit' => 50, 'created_at_min' => $created_after]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url?$params");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if (!isset($data['receipts'])) {
        error_log("No receipts returned or decoding failed: " . json_encode($data));
    }
    return $data['receipts'] ?? [];
}
