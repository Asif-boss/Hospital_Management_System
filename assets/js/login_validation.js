document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value.trim();
            const emailError = document.getElementById('loginEmailError');
            const passwordError = document.getElementById('loginPasswordError');

            emailError.textContent = '';
            passwordError.textContent = '';

            let isValid = true;

            if (email === '') {
                emailError.textContent = 'email is required';
                isValid = false;
            }

            if (password === '') {
                passwordError.textContent = 'Password is required';
                isValid = false;
            } else if (password.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters';
                isValid = false;
            }

            if (isValid) {
                loginForm.submit();
            }
        });
    }
});