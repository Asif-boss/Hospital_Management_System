<?php
session_start();

if (!isset($_COOKIE['user_type']) && !isset($_SESSION['user_type'])) {
    header('location: login.php');
} elseif (isset($_COOKIE['user_type'])) {
    if ($_COOKIE['user_type'] !== 'admin' && $_COOKIE['user_type'] !== 'super_admin') {
        header('location: login.php');
    }
} elseif (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] !== 'admin' && $_SESSION['user_type'] !== 'super_admin') {
        header('location: login.php');
    }
}

include 'header.php';
include '../controllers/inventoryController.php';
?>
    <link rel="stylesheet" href="../assets/css/inventory_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-boxes"></i> Inventory Management</h2>
        </div>

        <div class="inventory-stats">
            <div class="stat-card critical">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['critical']; ?></h3>
                    <p>Critical Stock Items</p>
                    <span class="stat-change">Immediate attention required</span>
                </div>
            </div>
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['low']; ?></h3>
                    <p>Low Stock Items</p>
                    <span class="stat-change">Reorder soon</span>
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['total']; ?></h3>
                    <p>Total Items</p>
                    <span class="stat-change">Well stocked</span>
                </div>
            </div>
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>$<?php echo number_format($stats['value'], 2); ?></h3>
                    <p>Inventory Value</p>
                    <span class="stat-change">Current worth</span>
                </div>
            </div>
        </div>

        <div class="inventory-container">
            <div class="inventory-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-plus"></i> Add New Item</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="add-item-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input type="text" name="item_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="drugs">Medicine</option>
                                        <option value="equipment">Equipment</option>
                                        <option value="ppe">PPE</option>
                                        <option value="supplies">Supplies</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Initial Stock</label>
                                    <input type="number" name="quantity" min="0" required>
                                </div>
                                <div class="form-group">
                                    <label>Minimum Stock</label>
                                    <input type="number" name="minimum_stock" min="0" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Unit Price ($)</label>
                                    <input type="number" name="unit_price" step="0.01" min="0" required>
                                </div>
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <input type="text" name="supplier" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="3"></textarea>
                            </div>

                            <button type="submit" name="add_item" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-exclamation-triangle"></i> Stock Alerts</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert-list">
                            <?php foreach ($alerts as $alert): 
                                $alert_level = $alert['quantity_in_stock'] <= $alert['reorder_level'] ? 'critical' : 'warning';
                                $item_name = '';
                                switch($alert['table']) {
                                    case 'drugs': $item_name = $alert['drug_name']; break;
                                    case 'equipment': $item_name = $alert['equipment_name']; break;
                                    case 'ppe': $item_name = $alert['ppe_name']; break;
                                    case 'supplies': $item_name = $alert['supply_name']; break;
                                }
                            ?>
                            <div class="stock-alert <?php echo $alert_level; ?>">
                                <div class="alert-icon">
                                    <i class="fas fa-<?php echo $alert_level == 'critical' ? 'exclamation-triangle' : 'box-open'; ?>"></i>
                                </div>
                                <div class="alert-info">
                                    <h4><?php echo $item_name; ?></h4>
                                    <p>Only <?php echo $alert['quantity_in_stock']; ?> units remaining</p>
                                    <span class="alert-level"><?php echo $alert_level == 'critical' ? 'Critical' : 'Low Stock'; ?></span>
                                </div>
                                <button class="btn btn-sm btn-<?php echo $alert_level == 'critical' ? 'danger' : 'warning'; ?>">Reorder</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                </div>
            </div>

            
            <div class="inventory-right">
                

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-search"></i> Search & Filter Inventory Items</h3>
                    </div>
                    <div class="card-body">
                        <div class="search-section">
                            <input type="text" placeholder="Search items..." class="search-input" id="inventorySearch">
                        </div>
                        <div class="filter-section">
                            <div class="filter-group">
                                <label>Category</label>
                                <select class="form-control" id="categoryFilter">
                                    <option value="">All Categories</option>
                                    <option value="drugs">Medicine</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="ppe">PPE</option>
                                    <option value="supplies">Supplies</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Stock Status</label>
                                <select class="form-control" id="stockFilter">
                                    <option value="">All Status</option>
                                    <option value="critical">Critical</option>
                                    <option value="low">Low Stock</option>
                                    <option value="normal">Normal</option>
                                </select>
                            </div>
                            <button class="btn btn-primary btn-block" onclick="applyInventoryFilters()">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="inventory-grid" id="inventoryGrid">
                            <?php foreach ($inventory_items as $item): 
                                $item_name = '';
                                $item_type = $item['item_type'];
                                
                                switch($item_type) {
                                    case 'drugs': 
                                        $item_name = $item['drug_name'];
                                        $expiry_field = $item['expiry_date'];
                                        break;
                                    case 'equipment': 
                                        $item_name = $item['equipment_name'];
                                        $expiry_field = $item['purchase_date'];
                                        break;
                                    case 'ppe': 
                                        $item_name = $item['ppe_name'];
                                        $expiry_field = $item['expiry_date'];
                                        break;
                                    case 'supplies': 
                                        $item_name = $item['supply_name'];
                                        $expiry_field = $item['expiry_date'];
                                        break;
                                }
                                
                                $is_critical = $item['quantity_in_stock'] <= $item['reorder_level'];
                            ?>
                            <div class="inventory-item <?php echo $is_critical ? 'critical' : 'normal'; ?>">
                                <div class="item-header">
                                    <h4><?php echo htmlspecialchars($item_name); ?></h4>
                                    <span class="stock-status"><?php echo $is_critical ? 'Critical' : 'Normal'; ?></span>
                                </div>
                                <div class="item-details">
                                    <p><strong>Current Stock:</strong> <?php echo $item['quantity_in_stock']; ?> units</p>
                                    <p><strong>Minimum Stock:</strong> <?php echo $item['reorder_level']; ?> units</p>
                                    <p><strong>Expiry/Purchase:</strong> <?php echo htmlspecialchars($expiry_field); ?></p>
                                    <p><strong>Category:</strong> <?php echo ucfirst($item_type); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </main>

    <script src="../assets/js/inventory.js"></script>
</body>
</html>