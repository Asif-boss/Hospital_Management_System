document.addEventListener('DOMContentLoaded', function() {
    // Function to show notifications
    function showNotification(message, isError = false) {
        // Remove any existing notifications first
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification ${isError ? 'error' : 'success'}`;
        notification.textContent = message;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.padding = '10px 20px';
        notification.style.backgroundColor = isError ? '#f44336' : '#4caf50';
        notification.style.color = '#fff';
        notification.style.borderRadius = '5px';
        notification.style.zIndex = '1000';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    // Edit Profile Form Submission
    const editProfileForm = document.getElementById('editProfileForm');
    if (editProfileForm) {
        editProfileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // --- JS Validation ---
            const fullName = document.getElementById('full_name').value.trim();
            const dob = document.getElementById('date_of_birth').value;
            const gender = document.getElementById('gender').value;
            const bloodGroup = document.getElementById('blood_group').value;
            const phone = document.getElementById('phone').value.trim();
            const nid = document.getElementById('nid').value.trim();
            const address = document.getElementById('address').value.trim();

            if (fullName.length < 2) {
                showNotification('Full Name is required', true);
                return;
            }
            if (!dob) {
                showNotification('Date of Birth is required', true);
                return;
            }
            if (!gender) {
                showNotification('Gender is required', true);
                return;
            }
            if (!bloodGroup) {
                showNotification('Blood Group is required', true);
                return;
            }
            if (phone.length < 6) {
                showNotification('Phone is required', true);
                return;
            }
            // NID and address can be optional, but you can add checks if needed

            // --- End JS Validation ---

            const formData = new FormData(this);
            formData.append('update_profile', '1');
            
            fetch('../controllers/profileController.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                // Show all errors, not just "Failed"
                const isError = data.toLowerCase().includes('fail') || data.toLowerCase().includes('error');
                showNotification(data, isError);
                if (!isError) {
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while updating profile', true);
            });
        });
    }

    // Change Password Form Submission
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Client-side validation
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                showNotification('New password and confirm password do not match', true);
                return;
            }
            
            if (newPassword.length < 6) {
                showNotification('New password must be at least 6 characters long', true);
                return;
            }
            
            const formData = new FormData(this);
            formData.append('change_password', '1');
            
            fetch('../controllers/profileController.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                showNotification(data, data.includes('Failed') || data.includes('incorrect') || data.includes('match') || data.includes('characters'));
                if (!data.includes('Failed') && !data.includes('incorrect') && !data.includes('match') && !data.includes('characters')) {
                    this.reset();
                    setTimeout(() => document.getElementById('changePasswordModal').style.display = 'none', 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while changing password', true);
            });
        });
    }

    // Avatar Upload Handling
    const avatarInput = document.getElementById('avatarInput');
    const avatarImage = document.getElementById('avatarImage');
    const changeAvatarBtn = document.getElementById('changeAvatarBtn');
    const avatarActions = document.getElementById('avatarActions');
    const updateAvatarBtn = document.getElementById('updateAvatarBtn');
    const cancelAvatarBtn = document.getElementById('cancelAvatarBtn');
    
    if (changeAvatarBtn && avatarInput) {
        changeAvatarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            avatarInput.click();
        });
    }
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    showNotification('Please select a valid image file (JPEG, PNG, GIF)', true);
                    this.value = '';
                    return;
                }
                
                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('Image size should be less than 2MB', true);
                    this.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
                
                // Show action buttons
                if (avatarActions) {
                    avatarActions.style.display = 'block';
                }
            }
        });
    }
    
    if (updateAvatarBtn) {
        updateAvatarBtn.addEventListener('click', function() {
            if (avatarInput.files.length === 0) {
                showNotification('Please select an image first', true);
                return;
            }
            
            const formData = new FormData();
            formData.append('avatar', avatarInput.files[0]);
            
            fetch('../controllers/profileController.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then (data => {
                showNotification(data, data.includes('Failed'));
                if (!data.includes('Failed')) {
                    if (avatarActions) {
                        avatarActions.style.display = 'none';
                    }
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while updating avatar', true);
            });
        });
    }
    
    if (cancelAvatarBtn) {
        cancelAvatarBtn.addEventListener('click', function() {
            avatarInput.value = '';
            if (avatarActions) {
                avatarActions.style.display = 'none';
            }
            // Reset to original image
            const originalSrc = avatarImage.dataset.originalSrc || '../assets/images/default-avatar.png';
            avatarImage.src = originalSrc;
        });
    }

    // Modal handling
    const editProfileModal = document.getElementById('editProfileModal');
    const changePasswordModal = document.getElementById('changePasswordModal');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const closeButtons = document.querySelectorAll('.close');
    const cancelEditProfile = document.getElementById('cancelEditProfile');
    const cancelChangePassword = document.getElementById('cancelChangePassword');

    // Open modals
    if (editProfileBtn && editProfileModal) {
        editProfileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            editProfileModal.style.display = 'block';
        });
    }

    if (changePasswordBtn && changePasswordModal) {
        changePasswordBtn.addEventListener('click', function(e) {
            e.preventDefault();
            changePasswordModal.style.display = 'block';
        });
    }

    // Close modals
    if (closeButtons) {
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (editProfileModal) editProfileModal.style.display = 'none';
                if (changePasswordModal) changePasswordModal.style.display = 'none';
            });
        });
    }

    if (cancelEditProfile && editProfileModal) {
        cancelEditProfile.addEventListener('click', function() {
            editProfileModal.style.display = 'none';
        });
    }

    if (cancelChangePassword && changePasswordModal) {
        cancelChangePassword.addEventListener('click', function() {
            changePasswordModal.style.display = 'none';
        });
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == editProfileModal) {
            editProfileModal.style.display = 'none';
        }
        if (event.target == changePasswordModal) {
            changePasswordModal.style.display = 'none';
        }
    });
});