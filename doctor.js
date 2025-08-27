function validatePatientSearch() {
    var query = document.getElementById('patientSearchInput').value.trim();
    if(query === "") {
        alert("Please enter a patient name or ID to search.");
        return false;
    }
    return true;
}

function validateAvailability() {
    var date = document.getElementById('availDate').value;
    var time = document.getElementById('availTime').value;
    if(date === "" || time === "") {
        alert("Please select both date and time.");
        return false;
    }
    var availabilityList = document.getElementById('availabilityList');
    var li = document.createElement('li');
    li.innerHTML = "Available on " + date + " at " + time;
    availabilityList.appendChild(li);
    document.getElementById('availabilityForm').reset();
    return false;
}

function validateEditProfile() {
    var contact = document.getElementById('contact').value.trim();
    var phoneRegex = /^\d{10}$/;
    if(!phoneRegex.test(contact)) {
        alert("Please enter a valid 10-digit contact number.");
        return false;
    }
    alert("Profile updated successfully!");
    return true;
}

function validatePrescription() {
    var patient = document.getElementById('presPatient').value.trim();
    var medicine = document.getElementById('presMedicine').value.trim();
    var dosage = document.getElementById('presDosage').value.trim();
    if(patient.length < 2 || medicine.length < 2 || dosage.length < 2) {
        alert("Patient, Medicine, and Dosage must each be at least 2 characters.");
        return false;
    }
    alert("Prescription sent!");
    return true;
}

function validateLabTest() {
    var patient = document.getElementById('labPatient').value.trim();
    var testType = document.getElementById('labType').value.trim();
    if(patient.length < 2 || testType.length < 2) {
        alert("Please enter valid Patient Name and Test Type.");
        return false;
    }
    alert("Lab test ordered!");
    return true;
}
