<?php
require_once('../models/db.php');

// --- Fetch all inventory items ---
function get_all_inventory_items($con) {
    $items = [];

    // Drugs
    $res = mysqli_query($con, "SELECT *, 'drugs' as item_type FROM drugs");
    while ($row = mysqli_fetch_assoc($res)) {
        $row['item_name'] = $row['drug_name'];
        $row['quantity_in_stock'] = (int)$row['quantity_in_stock'];
        $row['reorder_level'] = (int)$row['reorder_level'];
        $row['expiry_field'] = $row['expiry_date'];
        $items[] = $row;
    }

    // Equipment
    $res = mysqli_query($con, "SELECT *, 'equipment' as item_type FROM equipment");
    while ($row = mysqli_fetch_assoc($res)) {
        $row['item_name'] = $row['equipment_name'];
        $row['quantity_in_stock'] = (int)$row['quantity_in_stock'];
        $row['reorder_level'] = (int)$row['reorder_level'];
        $row['expiry_field'] = $row['purchase_date'];
        $items[] = $row;
    }

    // PPE
    $res = mysqli_query($con, "SELECT *, 'ppe' as item_type FROM ppe");
    while ($row = mysqli_fetch_assoc($res)) {
        $row['item_name'] = $row['ppe_name'];
        $row['quantity_in_stock'] = (int)$row['quantity_in_stock'];
        $row['reorder_level'] = (int)$row['reorder_level'];
        $row['expiry_field'] = $row['expiry_date'];
        $items[] = $row;
    }

    // Supplies
    $res = mysqli_query($con, "SELECT *, 'supplies' as item_type FROM supplies");
    while ($row = mysqli_fetch_assoc($res)) {
        $row['item_name'] = $row['supply_name'];
        $row['quantity_in_stock'] = (int)$row['quantity_in_stock'];
        $row['reorder_level'] = (int)$row['reorder_level'];
        $row['expiry_field'] = $row['expiry_date'];
        $items[] = $row;
    }

    return $items;
}

// --- Calculate stats ---
function get_inventory_stats($items) {
    $critical = 0;
    $low = 0;
    $total = count($items);
    $value = 0;

    foreach ($items as $item) {
        $qty = $item['quantity_in_stock'];
        $min = $item['reorder_level'];
        $val = $item['unit_price'] * $qty;
        $value += $val;

        if ($qty <= $min) $critical++;
        else if ($qty <= $min + 5) $low++;
    }

    return [
        'critical' => $critical,
        'low' => $low,
        'total' => $total,
        'value' => $value
    ];
}

// --- Get alerts (critical and low stock) ---
function get_stock_alerts($items) {
    $alerts = [];
    foreach ($items as $item) {
        if ($item['quantity_in_stock'] <= $item['reorder_level'] + 5) {
            $alerts[] = [
                'table' => $item['item_type'],
                'quantity_in_stock' => $item['quantity_in_stock'],
                'reorder_level' => $item['reorder_level'],
                'drug_name' => $item['drug_name'] ?? '',
                'equipment_name' => $item['equipment_name'] ?? '',
                'ppe_name' => $item['ppe_name'] ?? '',
                'supply_name' => $item['supply_name'] ?? ''
            ];
        }
    }
    return $alerts;
}

// --- Add new item ---
function add_inventory_item($con, $data) {
    $category = $data['category'];
    $fields = [
        'drugs' => ['drug_name', 'batch_number', 'category', 'quantity_in_stock', 'minimum_stock', 'unit_price', 'expiry_date', 'supplier', 'description', 'reorder_level'],
        'equipment' => ['equipment_name', 'model_number', 'category', 'quantity_in_stock', 'minimum_stock', 'unit_price', 'purchase_date', 'supplier', 'description', 'reorder_level'],
        'ppe' => ['ppe_name', 'batch_number', 'category', 'quantity_in_stock', 'minimum_stock', 'unit_price', 'expiry_date', 'supplier', 'description', 'reorder_level'],
        'supplies' => ['supply_name', 'batch_number', 'category', 'quantity_in_stock', 'minimum_stock', 'unit_price', 'expiry_date', 'supplier', 'description', 'reorder_level']
    ];

    if (!isset($fields[$category])) return false;

    // Map form fields to table fields
    $insert = [];
    foreach ($fields[$category] as $field) {
        if (isset($data[$field])) {
            $insert[$field] = mysqli_real_escape_string($con, $data[$field]);
        } else {
            $insert[$field] = null;
        }
    }

    // Special mapping for form fields
    if ($category == 'drugs') $insert['drug_name'] = $data['item_name'];
    if ($category == 'equipment') $insert['equipment_name'] = $data['item_name'];
    if ($category == 'ppe') $insert['ppe_name'] = $data['item_name'];
    if ($category == 'supplies') $insert['supply_name'] = $data['item_name'];

    // Set quantity and reorder fields
    $insert['quantity_in_stock'] = (int)$data['quantity'];
    $insert['minimum_stock'] = (int)$data['minimum_stock'];
    $insert['unit_price'] = (float)$data['unit_price'];
    $insert['reorder_level'] = (int)$data['minimum_stock'];
    $insert['supplier'] = $data['supplier'];
    $insert['description'] = $data['description'];

    // Set expiry/purchase date
    if ($category == 'equipment') {
        $insert['purchase_date'] = date('Y-m-d');
    } else {
        $insert['expiry_date'] = isset($data['expiry_date']) ? $data['expiry_date'] : null;
    }

    // Build query
    $columns = implode(',', array_keys($insert));
    $values = "'" . implode("','", array_map('addslashes', $insert)) . "'";
    $sql = "INSERT INTO $category ($columns) VALUES ($values)";
    return mysqli_query($con, $sql);
}

// --- DB Connection ---
$con = getConnection();

// Handle add item form
$success_message = '';
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    if (add_inventory_item($con, $_POST)) {
        $success_message = "Item added successfully!";
    } else {
        $error_message = "Failed to add item.";
    }
}

// Fetch all items, stats, and alerts
$inventory_items = get_all_inventory_items($con);
$stats = get_inventory_stats($inventory_items);
$alerts = get_stock_alerts($inventory_items);
?>