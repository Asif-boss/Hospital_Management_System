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
            <h2><i class="fas fa-user-circle"></i> Profile Management</h2>
        </div>

        <div class="profile-container">
            <div class="profile-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-user"></i> Personal Information</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="profile-form" id="profileForm" enctype="multipart/form-data">
                            <div class="profile-photo-section">
                                <div class="photo-container">
                                    <img src="https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=150&h=150&fit=crop&crop=face" alt="Profile Photo" id="profileImage">
                                    <div class="photo-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Change Photo</span>
                                    </div>
                                    <input type="file" id="photoUpload" name="profile_photo" accept="image/*" style="display: none;">
                                </div>
                                <div class="photo-actions">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="document.getElementById('photoUpload').click()">
                                        <i class="fas fa-upload"></i> Upload Photo
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePhoto()">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" value="John Doe" required>
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="1990-05-15" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" required>
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <select name="blood_group">
                                        <option value="">Select Blood Group</option>
                                        <option value="A+" selected>A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+" selected>O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>National ID (NID)</label>
                                    <input type="text" name="nid" value="1234567890123" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" value="+880-1234567890" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" value="john.doe@example.com" required>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" rows="3" required>123 Main Street, Dhaka 1000, Bangladesh</textarea>
                            </div>

                            <div class="id-scanner-section">
                                <h4><i class="fas fa-id-card"></i> ID Verification</h4>
                                <div class="scanner-container">
                                    <div class="scanner-area" id="scannerArea">
                                        <i class="fas fa-camera"></i>
                                        <p>Click to scan National ID</p>
                                        <input type="file" id="idScanner" accept="image/*" style="display: none;">
                                    </div>
                                    <div class="scanner-result" id="scannerResult" style="display: none;">
                                        <img id="scannedId" alt="Scanned ID">
                                        <div class="scan-actions">
                                            <button type="button" class="btn btn-sm btn-success" onclick="acceptScan()">
                                                <i class="fas fa-check"></i> Accept
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="rescan()">
                                                <i class="fas fa-redo"></i> Rescan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="update_profile" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="profile-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-phone"></i> Emergency Contacts</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($emergency_success)): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $emergency_success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="emergency-form">
                            <div class="emergency-contact">
                                <h4>Primary Contact</h4>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="emergency_name_1" value="Jane Doe" required>
                                </div>
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <select name="emergency_relation_1" required>
                                        <option value="spouse" selected>Spouse</option>
                                        <option value="parent">Parent</option>
                                        <option value="sibling">Sibling</option>
                                        <option value="child">Child</option>
                                        <option value="friend">Friend</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="emergency_phone_1" value="+880-0987654321" required>
                                </div>
                            </div>

                            <div class="emergency-contact">
                                <h4>Secondary Contact</h4>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="emergency_name_2" value="Robert Doe">
                                </div>
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <select name="emergency_relation_2">
                                        <option value="">Select Relationship</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="parent" selected>Parent</option>
                                        <option value="sibling">Sibling</option>
                                        <option value="child">Child</option>
                                        <option value="friend">Friend</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="emergency_phone_2" value="+880-1122334455">
                                </div>
                            </div>

                            <button type="submit" name="update_emergency" class="btn btn-success btn-block">
                                <i class="fas fa-save"></i> Update Emergency Contacts
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-allergies"></i> Medical Information</h3>
                    </div>
                    <div class="card-body">
                        <form class="medical-form">
                            <div class="form-group">
                                <label>Known Allergies</label>
                                <textarea name="allergies" rows="3" placeholder="List any known allergies...">Penicillin, Shellfish</textarea>
                            </div>

                            <div class="form-group">
                                <label>Current Medications</label>
                                <textarea name="medications" rows="3" placeholder="List current medications...">Lisinopril 10mg (daily), Metformin 500mg (twice daily)</textarea>
                            </div>

                            <div class="form-group">
                                <label>Medical Conditions</label>
                                <textarea name="conditions" rows="3" placeholder="List any chronic conditions...">Hypertension (controlled)</textarea>
                            </div>

                            <div class="form-group">
                                <label>Family Medical History</label>
                                <textarea name="family_history" rows="3" placeholder="Relevant family medical history...">Father: Diabetes, Mother: Hypertension</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Update Medical Info
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3><i class="fas fa-lock"></i> Account Security</h3>
                    </div>
                    <div class="card-body">
                        <form class="security-form">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" required>
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" required>
                            </div>

                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="confirm_password" required>
                            </div>

                            <button type="submit" class="btn btn-warning btn-block">
                                <i class="fas fa-key"></i> Change Password
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
