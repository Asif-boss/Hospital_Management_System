<?php
    if (!isset($_COOKIE['user_type'])) {
        header('location: ../login.php');
    }elseif ($_COOKIE['user_type'] !== 'admin') {
        header('location: ../login.php');
    }

    include '../templates/header.php';
?>

<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-boxes"></i> Inventory Management</h2>
            <div class="header-actions">
                <button class="btn btn-outline-primary" onclick="exportInventory()">
                    <i class="fas fa-download"></i> Export Report
                </button>
                <button class="btn btn-primary" onclick="openAddItemModal()">
                    <i class="fas fa-plus"></i> Add New Item
                </button>
            </div>
        </div>

        <div class="inventory-stats">
            <div class="stat-card critical">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>23</h3>
                    <p>Critical Stock Items</p>
                    <span class="stat-change">Immediate attention required</span>
                </div>
            </div>
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-info">
                    <h3>45</h3>
                    <p>Low Stock Items</p>
                    <span class="stat-change">Reorder soon</span>
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>892</h3>
                    <p>Total Items</p>
                    <span class="stat-change">Well stocked</span>
                </div>
            </div>
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>$45,230</h3>
                    <p>Inventory Value</p>
                    <span class="stat-change">Current worth</span>
                </div>
            </div>
        </div>

        <div class="inventory-container">
            <div class="inventory-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-search"></i> Search & Filter</h3>
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
                                    <option value="medicine">Medicine</option>
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
                                    <option value="overstocked">Overstocked</option>
                                </select>
                            </div>
                            <button class="btn btn-primary btn-block" onclick="applyInventoryFilters()">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-exclamation-triangle"></i> Stock Alerts</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert-list">
                            <div class="stock-alert critical">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-info">
                                    <h4>Surgical Masks</h4>
                                    <p>Only 15 units remaining</p>
                                    <span class="alert-level">Critical</span>
                                </div>
                                <button class="btn btn-sm btn-danger">Reorder Now</button>
                            </div>

                            <div class="stock-alert warning">
                                <div class="alert-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div class="alert-info">
                                    <h4>Disposable Gloves</h4>
                                    <p>45 units remaining</p>
                                    <span class="alert-level">Low Stock</span>
                                </div>
                                <button class="btn btn-sm btn-warning">Reorder</button>
                            </div>

                            <div class="stock-alert info">
                                <div class="alert-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="alert-info">
                                    <h4>Antibiotics</h4>
                                    <p>Expiring in 30 days</p>
                                    <span class="alert-level">Expiry Alert</span>
                                </div>
                                <button class="btn btn-sm btn-info">Check Stock</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inventory-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-list"></i> Inventory Items</h3>
                        <div class="view-options">
                            <button class="view-btn active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($add_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $add_success; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($update_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $update_success; ?>
                            </div>
                        <?php endif; ?>

                        <div class="inventory-grid" id="inventoryGrid">
                            <div class="inventory-item critical">
                                <div class="item-header">
                                    <h4>Surgical Masks</h4>
                                    <span class="stock-status critical">Critical</span>
                                </div>
                                <div class="item-details">
                                    <p><strong>Category:</strong> PPE</p>
                                    <p><strong>Current Stock:</strong> 15 units</p>
                                    <p><strong>Minimum Stock:</strong> 50 units</p>
                                    <p><strong>Unit Price:</strong> $2.50</p>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-sm btn-primary" onclick="updateStock('masks')">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                    <button class="btn btn-sm btn-success" onclick="reorderItem('masks')">
                                        <i class="fas fa-shopping-cart"></i> Reorder
                                    </button>
                                </div>
                            </div>

                            <div class="inventory-item warning">
                                <div class="item-header">
                                    <h4>Disposable Gloves</h4>
                                    <span class="stock-status warning">Low Stock</span>
                                </div>
                                <div class="item-details">
                                    <p><strong>Category:</strong> PPE</p>
                                    <p><strong>Current Stock:</strong> 45 units</p>
                                    <p><strong>Minimum Stock:</strong> 100 units</p>
                                    <p><strong>Unit Price:</strong> $0.75</p>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-sm btn-primary" onclick="updateStock('gloves')">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                    <button class="btn btn-sm btn-success" onclick="reorderItem('gloves')">
                                        <i class="fas fa-shopping-cart"></i> Reorder
                                    </button>
                                </div>
                            </div>

                            <div class="inventory-item normal">
                                <div class="item-header">
                                    <h4>Antibiotics</h4>
                                    <span class="stock-status normal">Normal</span>
                                </div>
                                <div class="item-details">
                                    <p><strong>Category:</strong> Medicine</p>
                                    <p><strong>Current Stock:</strong> 250 units</p>
                                    <p><strong>Minimum Stock:</strong> 100 units</p>
                                    <p><strong>Unit Price:</strong> $15.00</p>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-sm btn-primary" onclick="updateStock('antibiotics')">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('antibiotics')">
                                        <i class="fas fa-eye"></i> Details
                                    </button>
                                </div>
                            </div>

                            <div class="inventory-item normal">
                                <div class="item-header">
                                    <h4>Syringes</h4>
                                    <span class="stock-status normal">Normal</span>
                                </div>
                                <div class="item-details">
                                    <p><strong>Category:</strong> Supplies</p>
                                    <p><strong>Current Stock:</strong> 500 units</p>
                                    <p><strong>Minimum Stock:</strong> 200 units</p>
                                    <p><strong>Unit Price:</strong> $0.50</p>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-sm btn-primary" onclick="updateStock('syringes')">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('syringes')">
                                        <i class="fas fa-eye"></i> Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <option value="medicine">Medicine</option>
                                        <option value="equipment">Equipment</option>
                                        <option value="ppe">PPE</option>
                                        <option value="supplies">Supplies</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Initial Stock</label>
                                    <input type="number" name="initial_stock" min="0" required>
                                </div>
                                <div class="form-group">
                                    <label>Minimum Stock</label>
                                    <input type="number" name="minimum_stock" min="0" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Unit Price</label>
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
            </div>
        </div>
    </main>
</div>

<script src="../../assets/js/validation.js"></script>
</body>
</html>
