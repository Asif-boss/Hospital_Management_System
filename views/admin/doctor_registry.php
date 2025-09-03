<?php
    if (!isset($_COOKIE['user_type'])) {
        header('location: ../login.php');
    }elseif ($_COOKIE['user_type'] !== 'admin') {
        header('location: ../login.php');
    }

    include '../templates/header.php';
?>

$pageTitle = "Doctor Registry";
$extraCSS = "admin.css";
include '../templates/header.php';
?>

<div class="dashboard-layout">
    <?php include '../templates/sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-user-md"></i> Doctor Registry Management</h2>
        </div>

        <div class="registry-container">
            <div class="registry-left">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Search National DB (Simulated)</h3>
                    </div>
                    <div class="card-body">
                        <div class="search-section">
                            <div class="search-bar">
                                <input type="text" placeholder="Search by name or specialty" class="search-input">
                                <button class="btn btn-primary">Search</button>
                            </div>
                        </div>
                        
                        <div class="search-results">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>License</th>
                                        <th>Name</th>
                                        <th>Specialty</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BD-12345</td>
                                        <td>Dr. Priya Sen</td>
                                        <td>Cardiology</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="addToLocal('BD-12345', 'Dr. Priya Sen', 'Cardiology')">
                                                Add to Local
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>BD-67890</td>
                                        <td>Dr. Rahman Ali</td>
                                        <td>Neurology</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="addToLocal('BD-67890', 'Dr. Rahman Ali', 'Neurology')">
                                                Add to Local
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>BD-54321</td>
                                        <td>Dr. Fatima Khan</td>
                                        <td>Pediatrics</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="addToLocal('BD-54321', 'Dr. Fatima Khan', 'Pediatrics')">
                                                Add to Local
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Local Doctors</h3>
                        <button class="btn btn-primary btn-sm" onclick="openAddDoctorModal()">
                            <i class="fas fa-plus"></i> Add Doctor
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="data-table" id="localDoctorsTable">
                            <thead>
                                <tr>
                                    <th>License</th>
                                    <th>Name</th>
                                    <th>Specialty</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>BD-11111</td>
                                    <td>Dr. Sarah Johnson</td>
                                    <td>Cardiology</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger">Remove</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>BD-22222</td>
                                    <td>Dr. Michael Brown</td>
                                    <td>General Medicine</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="registry-right">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Add to Local Registry</h3>
                    </div>
                    <div class="card-body">
                        <form class="doctor-form" id="addDoctorForm">
                            <div class="form-group">
                                <label>License No.</label>
                                <input type="text" id="doctorLicense" placeholder="BD-12345" required>
                            </div>
                            <div class="form-group">
                                <label>Doctor Name</label>
                                <input type="text" id="doctorName" placeholder="Dr. Priya Sen" required>
                            </div>
                            <div class="form-group">
                                <label>Specialty</label>
                                <input type="text" id="doctorSpecialty" placeholder="Cardiology" required>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="tel" placeholder="+880-1234567890">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" placeholder="doctor@bdhospital.com">
                            </div>
                            <button type="button" class="btn btn-success" onclick="addDoctor()">
                                <i class="fas fa-plus"></i> Add Doctor
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Publish to National DB (Simulated)</h3>
                    </div>
                    <div class="card-body">
                        <form class="doctor-form">
                            <div class="form-group">
                                <label>License No.</label>
                                <input type="text" placeholder="BD-67890" value="BD-67890">
                            </div>
                            <div class="form-group">
                                <label>Doctor Name</label>
                                <input type="text" placeholder="Dr. Hasan" value="Dr. Hasan">
                            </div>
                            <div class="form-group">
                                <label>Specialty</label>
                                <input type="text" placeholder="Pediatrics" value="Pediatrics">
                            </div>
                            <div class="form-group">
                                <label>Verification Status</label>
                                <select>
                                    <option>Verified</option>
                                    <option>Pending</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Publish
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="../../assets/js/validation.js"></script>
<script>
function addToLocal(license, name, specialty) {
    document.getElementById('doctorLicense').value = license;
    document.getElementById('doctorName').value = name;
    document.getElementById('doctorSpecialty').value = specialty;
}

function addDoctor() {
    const license = document.getElementById('doctorLicense').value;
    const name = document.getElementById('doctorName').value;
    const specialty = document.getElementById('doctorSpecialty').value;
    
    if (!license || !name || !specialty) {
        alert('Please fill all required fields');
        return;
    }
    
    // Add to local table
    const tbody = document.querySelector('#localDoctorsTable tbody');
    const row = tbody.insertRow();
    row.innerHTML = `
        <td>${license}</td>
        <td>${name}</td>
        <td>${specialty}</td>
        <td>
            <button class="btn btn-sm btn-outline-primary">Edit</button>
            <button class="btn btn-sm btn-outline-danger">Remove</button>
        </td>
    `;
    
    // Clear form
    document.getElementById('addDoctorForm').reset();
    
    alert('Doctor added successfully to local registry!');
}
</script>
</body>
</html>