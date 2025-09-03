function validatePrescription() {
    var p = document.getElementById('presPatient').value.trim();
    var m = document.getElementById('presMedicine').value.trim();
    var d = document.getElementById('presDosage').value.trim();
    if (p.length < 2 || m.length < 2 || d.length < 2) {
        alert("All fields must be at least 2 characters.");
        return false;
    }
    return true;
}

function validateEditProfile() {
    var contact = document.getElementById('contact').value.trim();
    var phoneRegex = /^\d{11}$/;
    if (!phoneRegex.test(contact)) {
        alert("Please enter a valid 11-digit contact number.");
        return false;
    }
    return true;
}

function validateLabTest() {
    // Get the values of the form fields
    var patient = document.getElementById('testPatient').value.trim();
    var testName = document.getElementById('testName').value.trim();
    var testDescription = document.getElementById('testDescription').value.trim();
    var testDate = document.getElementById('testDate').value.trim();

    // Validate the fields
    if (patient.length < 2) {
        alert("Patient name must be at least 2 characters.");
        return false;
    }

    if (testName.length < 2) {
        alert("Test name must be at least 2 characters.");
        return false;
    }

    if (testDescription.length < 2) {
        alert("Test description must be at least 2 characters.");
        return false;
    }

    if (testDate === "") {
        alert("Test date is required.");
        return false;
    }

    // If all validations pass, return true
    return true;
}


function filterDoctors() {
    var input = document.getElementById('doctorSearchInput').value.toLowerCase();
    var specialty = document.getElementById('specialtyFilter').value;
    var doctors = document.querySelectorAll('#doctorDirectory ul li');

    doctors.forEach(function (doctor) {
        var id = doctor.getAttribute('data-id').toLowerCase();
        var name = doctor.getAttribute('data-name').toLowerCase();
        var docSpecialty = doctor.getAttribute('data-specialty').toLowerCase();

        var matchesSearch = id.includes(input) || name.includes(input);
        var matchesSpecialty = specialty === 'all' || docSpecialty === specialty;

        doctor.style.display = (matchesSearch && matchesSpecialty) ? '' : 'none';
    });
}
