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
            <h2><i class="fas fa-history"></i> Medical History</h2>
            <div class="header-actions">
                <button class="btn btn-outline-primary" onclick="exportHistory()">
                    <i class="fas fa-download"></i> Export Data
                </button>
                <button class="btn btn-primary" onclick="requestRecord()">
                    <i class="fas fa-plus"></i> Request Record
                </button>
            </div>
        </div>

        <div class="history-container">
            <div class="history-filters">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-filter"></i> Filter Records</h3>
                    </div>
                    <!-- <div class="card-body">
                        <div class="filter-group">
                            <label>Date Range</label>
                            <div class="date-range">
                                <input type="date" id="startDate" class="form-control">
                                <span>to</span>
                                <input type="date" id="endDate" class="form-control">
                            </div>
                        </div>
                        <div class="filter-group">
                            <label>Record Type</label>
                            <select class="form-control">
                                <option value="">All Types</option>
                                <option value="consultation">Consultation</option>
                                <option value="lab">Lab Results</option>
                                <option value="prescription">Prescription</option>
                                <option value="surgery">Surgery</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Doctor</label>
                            <select class="form-control">
                                <option value="">All Doctors</option>
                                <option value="dr-sarah">Dr. Sarah Johnson</option>
                                <option value="dr-michael">Dr. Michael Brown</option>
                                <option value="dr-emily">Dr. Emily Davis</option>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-block" onclick="applyFilters()">
                            <i class="fas fa-search"></i> Apply Filters
                        </button>
                    </div> -->
                </div>
            </div>

            <div class="history-timeline">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-timeline"></i> Medical Timeline</h3>
                        <div class="view-options">
                            <button class="view-btn active" data-view="timeline">Timeline</button>
                            <button class="view-btn" data-view="summary">Summary</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="timeline-view active" id="timelineView">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker consultation">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <h4>Cardiology Consultation</h4>
                                            <span class="timeline-date">December 10, 2024</span>
                                        </div>
                                        <div class="timeline-details">
                                            <p><strong>Doctor:</strong> Dr. Sarah Johnson</p>
                                            <p><strong>Diagnosis:</strong> Hypertension Follow-up</p>
                                            <p><strong>Treatment:</strong> Medication adjustment, lifestyle counseling</p>
                                            <p><strong>Notes:</strong> Blood pressure well controlled. Continue current medication.</p>
                                            <div class="timeline-attachments">
                                                <a href="#" class="attachment-link">
                                                    <i class="fas fa-file-pdf"></i> Consultation Report
                                                </a>
                                                <a href="#" class="attachment-link">
                                                    <i class="fas fa-chart-line"></i> BP Readings
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-marker lab">
                                        <i class="fas fa-flask"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <h4>Laboratory Results</h4>
                                            <span class="timeline-date">December 8, 2024</span>
                                        </div>
                                        <div class="timeline-details">
                                            <p><strong>Test Type:</strong> Complete Blood Count (CBC)</p>
                                            <p><strong>Ordered by:</strong> Dr. Sarah Johnson</p>
                                            <div class="lab-results">
                                                <div class="result-item normal">
                                                    <span>Hemoglobin: 14.2 g/dL</span>
                                                    <span class="result-status">Normal</span>
                                                </div>
                                                <div class="result-item normal">
                                                    <span>White Blood Cells: 7,200/μL</span>
                                                    <span class="result-status">Normal</span>
                                                </div>
                                                <div class="result-item normal">
                                                    <span>Platelets: 280,000/μL</span>
                                                    <span class="result-status">Normal</span>
                                                </div>
                                            </div>
                                            <div class="timeline-attachments">
                                                <a href="#" class="attachment-link">
                                                    <i class="fas fa-file-medical"></i> Full Lab Report
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-marker prescription">
                                        <i class="fas fa-prescription-bottle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <h4>Prescription Update</h4>
                                            <span class="timeline-date">November 25, 2024</span>
                                        </div>
                                        <div class="timeline-details">
                                            <p><strong>Doctor:</strong> Dr. Sarah Johnson</p>
                                            <p><strong>Medications:</strong></p>
                                            <div class="medication-list">
                                                <div class="med-item">
                                                    <span class="med-name">Lisinopril 10mg</span>
                                                    <span class="med-dosage">Once daily</span>
                                                </div>
                                                <div class="med-item">
                                                    <span class="med-name">Metformin 500mg</span>
                                                    <span class="med-dosage">Twice daily with meals</span>
                                                </div>
                                            </div>
                                            <div class="timeline-attachments">
                                                <a href="#" class="attachment-link">
                                                    <i class="fas fa-prescription"></i> Prescription Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-marker surgery">
                                        <i class="fas fa-procedures"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <h4>Minor Surgery</h4>
                                            <span class="timeline-date">October 15, 2024</span>
                                        </div>
                                        <div class="timeline-details">
                                            <p><strong>Surgeon:</strong> Dr. Robert Wilson</p>
                                            <p><strong>Procedure:</strong> Mole removal (left shoulder)</p>
                                            <p><strong>Duration:</strong> 30 minutes</p>
                                            <p><strong>Outcome:</strong> Successful, no complications</p>
                                            <p><strong>Recovery:</strong> Complete healing in 2 weeks</p>
                                            <div class="timeline-attachments">
                                                <a href="#" class="attachment-link">
                                                    <i class="fas fa-file-medical"></i> Surgery Report
                                                </a>
                                                <a href="#" class="attachment-link">
                                                    <i class="fas fa-images"></i> Post-op Photos
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="summary-view" id="summaryView">
                            <div class="summary-stats">
                                <div class="summary-card">
                                    <div class="summary-icon consultation">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div class="summary-info">
                                        <h3>12</h3>
                                        <p>Total Consultations</p>
                                    </div>
                                </div>
                                <div class="summary-card">
                                    <div class="summary-icon lab">
                                        <i class="fas fa-flask"></i>
                                    </div>
                                    <div class="summary-info">
                                        <h3>8</h3>
                                        <p>Lab Tests</p>
                                    </div>
                                </div>
                                <div class="summary-card">
                                    <div class="summary-icon prescription">
                                        <i class="fas fa-prescription-bottle"></i>
                                    </div>
                                    <div class="summary-info">
                                        <h3>15</h3>
                                        <p>Prescriptions</p>
                                    </div>
                                </div>
                                <div class="summary-card">
                                    <div class="summary-icon surgery">
                                        <i class="fas fa-procedures"></i>
                                    </div>
                                    <div class="summary-info">
                                        <h3>2</h3>
                                        <p>Procedures</p>
                                    </div>
                                </div>
                            </div>

                            <div class="summary-details">
                                <h4>Health Summary</h4>
                                <div class="health-indicators">
                                    <div class="indicator-item">
                                        <span class="indicator-label">Current Conditions:</span>
                                        <span class="indicator-value">Hypertension (controlled)</span>
                                    </div>
                                    <div class="indicator-item">
                                        <span class="indicator-label">Allergies:</span>
                                        <span class="indicator-value">Penicillin, Shellfish</span>
                                    </div>
                                    <div class="indicator-item">
                                        <span class="indicator-label">Blood Type:</span>
                                        <span class="indicator-value">O+</span>
                                    </div>
                                    <div class="indicator-item">
                                        <span class="indicator-label">Last Visit:</span>
                                        <span class="indicator-value">December 10, 2024</span>
                                    </div>
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
