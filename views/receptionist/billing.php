<?php
if (!isset($_COOKIE['user_type'])) {
    header('location: ../login.php');
} elseif ($_COOKIE['user_type'] !== 'receptionist') {
    header('location: ../login.php');
}

include '../templates/header.php';
?>

<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>
    <main class="main-content">
        <div class="page-header">
            <?php include '../templates/sidebar.php'; ?>
            <h2><i class="fas fa-file-invoice-dollar"></i> Billing & Insurance Management</h2>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="showNewInvoice()">
                    <i class="fas fa-plus"></i> New Invoice
                </button>
                <button class="btn btn-outline-primary" onclick="showInsuranceCalculator()">
                    <i class="fas fa-calculator"></i> Insurance Calculator
                </button>
                <button class="btn btn-outline-secondary" onclick="exportBillingData()">
                    <i class="fas fa-download"></i> Export Data
                </button>
            </div>
        </div>

        <div class="billing-container">
            <div class="content-left">
                <!-- Recent Invoices -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-file-invoice"></i> Recent Invoices</h3>
                        <div class="billing-filters">
                            <select onchange="filterInvoices(this.value)">
                                <option value="all">All Status</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="bills-list">
                            <div class="bill-item">
                                <div class="bill-header">
                                    <div class="bill-info">
                                        <h4>Invoice #INV-2025-001</h4>
                                        <p>Patient: Ahmed Hassan | NID: 1234567890123</p>
                                    </div>
                                    <div class="bill-amount">
                                        <span class="amount">৳2,500</span>
                                        <span class="status paid">Paid</span>
                                    </div>
                                </div>
                                <div class="bill-details">
                                    <div class="service-line">
                                        <span>Cardiology Consultation</span>
                                        <span>৳1,500</span>
                                    </div>
                                    <div class="service-line">
                                        <span>ECG Test</span>
                                        <span>৳800</span>
                                    </div>
                                    <div class="service-line">
                                        <span>Medicines</span>
                                        <span>৳200</span>
                                    </div>
                                    <hr>
                                    <div class="service-line total">
                                        <strong>Total Amount: ৳2,500</strong>
                                    </div>

                                    <div class="bill-actions">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewInvoice('INV-2025-001')">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="printInvoice('INV-2025-001')">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="downloadInvoice('INV-2025-001')">
                                            <i class="fas fa-download"></i> PDF
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="bill-item">
                                <div class="bill-header">
                                    <div class="bill-info">
                                        <h4>Invoice #INV-2025-002</h4>
                                        <p>Patient: Sarah Khan | NID: 9876543210987</p>
                                    </div>
                                    <div class="bill-amount">
                                        <span class="amount">৳4,200</span>
                                        <span class="status pending">Pending</span>
                                    </div>
                                </div>
                                <div class="bill-details">
                                    <div class="service-line">
                                        <span>Pediatric Consultation</span>
                                        <span>৳1,200</span>
                                    </div>
                                    <div class="service-line">
                                        <span>Blood Test Panel</span>
                                        <span>৳2,000</span>
                                    </div>
                                    <div class="service-line">
                                        <span>X-Ray</span>
                                        <span>৳1,000</span>
                                    </div>
                                    <hr>
                                    <div class="service-line total">
                                        <strong>Total Amount: ৳4,200</strong>
                                    </div>

                                    <div class="bill-actions">
                                        <button class="btn btn-sm btn-primary" onclick="collectPayment('INV-2025-002')">
                                            <i class="fas fa-credit-card"></i> Collect Payment
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewInvoice('INV-2025-002')">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="sendReminder('INV-2025-002')">
                                            <i class="fas fa-envelope"></i> Send Reminder
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="bill-item">
                                <div class="bill-header">
                                    <div class="bill-info">
                                        <h4>Invoice #INV-2025-003</h4>
                                        <p>Patient: Mohammad Ali | NID: 5432167890123</p>
                                    </div>
                                    <div class="bill-amount">
                                        <span class="amount">৳8,500</span>
                                        <span class="status overdue">Overdue</span>
                                    </div>
                                </div>
                                <div class="bill-details">
                                    <div class="service-line">
                                        <span>Orthopedic Consultation</span>
                                        <span>৳1,500</span>
                                    </div>
                                    <div class="service-line">
                                        <span>MRI Scan</span>
                                        <span>৳5,000</span>
                                    </div>
                                    <div class="service-line">
                                        <span>Physiotherapy (3 sessions)</span>
                                        <span>৳2,000</span>
                                    </div>
                                    <hr>
                                    <div class="service-line total">
                                        <strong>Total Amount: ৳8,500</strong>
                                    </div>

                                    <div class="bill-actions">
                                        <button class="btn btn-sm btn-danger" onclick="followUpPayment('INV-2025-003')">
                                            <i class="fas fa-phone"></i> Follow Up
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewInvoice('INV-2025-003')">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" onclick="setPaymentPlan('INV-2025-003')">
                                            <i class="fas fa-calendar-alt"></i> Payment Plan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-right">
                <!-- Payment Summary -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-chart-line"></i> Payment Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="payment-stats">
                            <div class="payment-stat">
                                <div class="stat-value">৳45,200</div>
                                <div class="stat-label">Today's Collections</div>
                            </div>
                            <div class="payment-stat">
                                <div class="stat-value">৳285,600</div>
                                <div class="stat-label">This Week</div>
                            </div>
                            <div class="payment-stat">
                                <div class="stat-value">৳85,400</div>
                                <div class="stat-label">Pending Payments</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Insurance Information -->
                <div class="dashboard-card">
                    <div class="card-body">
                        <div class="insurance-card">
                            <div class="insurance-header">
                                <h4><i class="fas fa-shield-alt"></i> Insurance Claims</h4>
                                <span class="insurance-status">Active</span>
                            </div>
                            <div class="insurance-details">
                                <div class="detail-row">
                                    <span class="label">Pending Claims:</span>
                                    <span class="value">8</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Approved This Month:</span>
                                    <span class="value">42</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Total Claim Value:</span>
                                    <span class="value">৳485,000</span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block" onclick="showNewClaim()">
                            <i class="fas fa-plus"></i> Submit New Claim
                        </button>
                    </div>
                </div>

                <!-- Recent Claims -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-list-alt"></i> Recent Claims</h3>
                    </div>
                    <div class="card-body">
                        <div class="claims-list">
                            <div class="claim-item">
                                <div class="claim-info">
                                    <h4>Claim #CLM-001</h4>
                                    <p>Patient: Mohammad Ali</p>
                                    <span class="claim-type">Orthopedic Surgery</span>
                                </div>
                                <div class="claim-status">
                                    <span class="amount">৳25,000</span>
                                    <span class="status processing">Processing</span>
                                </div>
                            </div>

                            <div class="claim-item">
                                <div class="claim-info">
                                    <h4>Claim #CLM-002</h4>
                                    <p>Patient: Fatima Begum</p>
                                    <span class="claim-type">Emergency Treatment</span>
                                </div>
                                <div class="claim-status">
                                    <span class="amount">৳12,500</span>
                                    <span class="status approved">Approved</span>
                                </div>
                            </div>

                            <div class="claim-item">
                                <div class="claim-info">
                                    <h4>Claim #CLM-003</h4>
                                    <p>Patient: Karim Ahmed</p>
                                    <span class="claim-type">Cardiac Procedure</span>
                                </div>
                                <div class="claim-status">
                                    <span class="amount">৳35,000</span>
                                    <span class="status pending">Under Review</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Payment History</h3>
                    </div>
                    <div class="card-body">
                        <div class="payment-history">
                            <div class="payment-item">
                                <div class="payment-info">
                                    <h4>Ahmed Hassan</h4>
                                    <p>Cardiology consultation</p>
                                    <span class="payment-date">15 Jan 2025, 11:45 AM</span>
                                </div>
                                <div class="payment-details">
                                    <span class="amount">৳2,500</span>
                                    <span class="method">Cash</span>
                                </div>
                            </div>

                            <div class="payment-item">
                                <div class="payment-info">
                                    <h4>Fatima Begum</h4>
                                    <p>Emergency treatment</p>
                                    <span class="payment-date">14 Jan 2025, 8:30 PM</span>
                                </div>
                                <div class="payment-details">
                                    <span class="amount">৳12,500</span>
                                    <span class="method">Insurance + Cash</span>
                                </div>
                            </div>

                            <div class="payment-item">
                                <div class="payment-info">
                                    <h4>Rahman Khan</h4>
                                    <p>Routine checkup</p>
                                    <span class="payment-date">14 Jan 2025, 2:15 PM</span>
                                </div>
                                <div class="payment-details">
                                    <span class="amount">৳1,200</span>
                                    <span class="method">Digital Payment</span>
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