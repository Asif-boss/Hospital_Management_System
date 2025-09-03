<?php
    if (!isset($_COOKIE['user_type'])) {
        header('location: ../login.php');
    }elseif ($_COOKIE['user_type'] !== 'patient') {
        header('location: ../login.php');
    }

    include '../templates/header.php';
?>

<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-file-invoice-dollar"></i> Billing & Insurance</h2>
            <div class="header-actions">
                <button class="btn btn-outline-primary" onclick="downloadStatement()">
                    <i class="fas fa-download"></i> Download Statement
                </button>
                <button class="btn btn-primary" onclick="makePayment()">
                    <i class="fas fa-credit-card"></i> Make Payment
                </button>
            </div>
        </div>

        <div class="billing-container">
            <div class="billing-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-receipt"></i> Outstanding Bills</h3>
                    </div>
                    <div class="card-body">
                        <div class="bill-item">
                            <div class="bill-header">
                                <div class="bill-info">
                                    <h4>Cardiology Consultation</h4>
                                    <p>Dr. Sarah Johnson • December 10, 2024</p>
                                </div>
                                <div class="bill-amount">
                                    <span class="amount">$120.00</span>
                                    <span class="status overdue">Overdue</span>
                                </div>
                            </div>
                            <div class="bill-details">
                                <div class="service-line">
                                    <span>Consultation Fee</span>
                                    <span>$80.00</span>
                                </div>
                                <div class="service-line">
                                    <span>ECG Test</span>
                                    <span>$40.00</span>
                                </div>
                                <div class="bill-actions">
                                    <button class="btn btn-sm btn-primary">Pay Now</button>
                                    <button class="btn btn-sm btn-outline-primary">View Details</button>
                                </div>
                            </div>
                        </div>

                        <div class="bill-item">
                            <div class="bill-header">
                                <div class="bill-info">
                                    <h4>Laboratory Tests</h4>
                                    <p>Complete Blood Count • December 8, 2024</p>
                                </div>
                                <div class="bill-amount">
                                    <span class="amount">$45.00</span>
                                    <span class="status pending">Pending</span>
                                </div>
                            </div>
                            <div class="bill-details">
                                <div class="service-line">
                                    <span>CBC Test</span>
                                    <span>$35.00</span>
                                </div>
                                <div class="service-line">
                                    <span>Processing Fee</span>
                                    <span>$10.00</span>
                                </div>
                                <div class="bill-actions">
                                    <button class="btn btn-sm btn-primary">Pay Now</button>
                                    <button class="btn btn-sm btn-outline-primary">View Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Payment History</h3>
                        <div class="period-selector">
                            <select class="form-control">
                                <option>Last 3 Months</option>
                                <option>Last 6 Months</option>
                                <option>Last Year</option>
                                <option>All Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="payment-history">
                            <div class="payment-item paid">
                                <div class="payment-info">
                                    <h4>General Checkup</h4>
                                    <p>Dr. Michael Brown • November 25, 2024</p>
                                </div>
                                <div class="payment-details">
                                    <span class="amount">$95.00</span>
                                    <span class="status">Paid</span>
                                    <span class="method">Credit Card</span>
                                </div>
                            </div>

                            <div class="payment-item paid">
                                <div class="payment-info">
                                    <h4>Surgery - Mole Removal</h4>
                                    <p>Dr. Robert Wilson • October 15, 2024</p>
                                </div>
                                <div class="payment-details">
                                    <span class="amount">$450.00</span>
                                    <span class="status">Paid</span>
                                    <span class="method">Insurance + Cash</span>
                                </div>
                            </div>

                            <div class="payment-item paid">
                                <div class="payment-info">
                                    <h4>Blood Work</h4>
                                    <p>Laboratory • October 10, 2024</p>
                                </div>
                                <div class="payment-details">
                                    <span class="amount">$65.00</span>
                                    <span class="status">Paid</span>
                                    <span class="method">Insurance</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="billing-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-shield-alt"></i> Insurance Information</h3>
                        <button class="btn btn-sm btn-outline-primary" onclick="updateInsurance()">
                            <i class="fas fa-edit"></i> Update
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="insurance-card">
                            <div class="insurance-header">
                                <h4>Primary Insurance</h4>
                                <span class="insurance-status active">Active</span>
                            </div>
                            <div class="insurance-details">
                                <div class="detail-row">
                                    <span class="label">Provider:</span>
                                    <span class="value">Bangladesh Health Insurance</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Policy Number:</span>
                                    <span class="value">BHI-123456789</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Group Number:</span>
                                    <span class="value">GRP-456</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Coverage:</span>
                                    <span class="value">80% after deductible</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Deductible:</span>
                                    <span class="value">$500 (Met: $320)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-file-medical"></i> Submit Insurance Claim</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success) && isset($_POST['submit_claim'])): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="claim-form" id="claimForm">
                            <div class="form-group">
                                <label>Service Date</label>
                                <input type="date" name="service_date" required>
                            </div>

                            <div class="form-group">
                                <label>Service Type</label>
                                <select name="service_type" required>
                                    <option value="">Select Service</option>
                                    <option value="consultation">Consultation</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="surgery">Surgery</option>
                                    <option value="emergency">Emergency</option>
                                    <option value="pharmacy">Pharmacy</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Provider</label>
                                <input type="text" name="provider" placeholder="Dr. Sarah Johnson" required>
                            </div>

                            <div class="form-group">
                                <label>Total Amount</label>
                                <input type="number" name="amount" step="0.01" placeholder="0.00" required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="3" placeholder="Brief description of services received" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Upload Receipt</label>
                                <input type="file" name="receipt" accept=".pdf,.jpg,.jpeg,.png">
                                <small>Supported formats: PDF, JPG, PNG (Max 5MB)</small>
                            </div>

                            <button type="submit" name="submit_claim" class="btn btn-primary btn-block">
                                <i class="fas fa-paper-plane"></i> Submit Claim
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-list-alt"></i> Recent Claims</h3>
                    </div>
                    <div class="card-body">
                        <div class="claims-list">
                            <div class="claim-item">
                                <div class="claim-info">
                                    <h4>Cardiology Visit</h4>
                                    <p>Claim ID: CLM-789123</p>
                                </div>
                                <div class="claim-status">
                                    <span class="amount">$120.00</span>
                                    <span class="status approved">Approved</span>
                                </div>
                            </div>

                            <div class="claim-item">
                                <div class="claim-info">
                                    <h4>Lab Tests</h4>
                                    <p>Claim ID: CLM-456789</p>
                                </div>
                                <div class="claim-status">
                                    <span class="amount">$65.00</span>
                                    <span class="status processing">Processing</span>
                                </div>
                            </div>

                            <div class="claim-item">
                                <div class="claim-info">
                                    <h4>Surgery</h4>
                                    <p>Claim ID: CLM-123456</p>
                                </div>
                                <div class="claim-status">
                                    <span class="amount">$450.00</span>
                                    <span class="status approved">Approved</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="../../assets/js/validation.js"></script>
</body>
</html>
