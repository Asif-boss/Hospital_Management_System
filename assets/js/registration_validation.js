document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            
            event.preventDefault();

            const name = document.getElementById('regName').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const nid = document.getElementById('regNid').value.trim();
            const phone = document.getElementById('regPhone').value.trim();
            const password = document.getElementById('regPassword').value.trim();
            const confirmPassword = document.getElementById('regConfirmPassword').value.trim();
            const dob = document.getElementById('regDob').value.trim();
            const gender = document.getElementById('regGender').value.trim();
            const bloodGroup = document.getElementById('regBloodGroup').value.trim();
            const agreeTerms = document.getElementById('agreeTerms').checked;

            const nameError = document.getElementById('regNameError');
            const emailError = document.getElementById('regEmailError');
            const nidError = document.getElementById('regNidError');
            const phoneError = document.getElementById('regPhoneError');
            const passwordError = document.getElementById('regPasswordError');
            const confirmPasswordError = document.getElementById('regConfirmPasswordError');
            const dobError = document.getElementById('regDobError');
            const genderError = document.getElementById('regGenderError');
            const bloodGroupError = document.getElementById('regBloodGroupError');
            const conditionsError = document.getElementById('conditionsError');

            nameError.textContent = '';
            emailError.textContent = '';
            nidError.textContent = '';
            phoneError.textContent = '';
            passwordError.textContent = '';
            confirmPasswordError.textContent = '';
            dobError.textContent = '';
            genderError.textContent = '';
            bloodGroupError.textContent = '';
            conditionsError.textContent = '';

            let isValid = true;

            if (name === '') {
                nameError.textContent = 'Full name is required';
                isValid = false;
            }

            if (email === '') {
                emailError.textContent = 'Email is required';
                isValid = false;
            }

            if (nid === '') {
                nidError.textContent = 'National ID is required';
                isValid = false;
            }

            if (phone === '') {
                phoneError.textContent = 'Phone number is required';
                isValid = false;
            }

            if (password === '') {
                passwordError.textContent = 'Password is required';
                isValid = false;
            } else if (password.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters';
                isValid = false;
            }

            if (confirmPassword === '') {
                confirmPasswordError.textContent = 'Confirm password is required';
                isValid = false;
            } else if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match';
                isValid = false;
            }

            if (dob === '') {
                dobError.textContent = 'Date of Birth is required';
                isValid = false;
            }

            if (gender === '') {
                genderError.textContent = 'Gender is required';
                isValid = false;
            }

            if (bloodGroup === '') {
                bloodGroupError.textContent = 'Blood Group is required';
                isValid = false;
            }

            if (!agreeTerms) {
                conditionsError.textContent = 'You must agree to the Terms & Conditions';
                isValid = false;
            }

            if (isValid) {
                registerForm.submit();
            }
        });
    }
});