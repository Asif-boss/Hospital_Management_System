
function toggleNotifications() {
    const dropdown = document.getElementById('notificationsDropdown');
    if (dropdown) {
        dropdown.classList.toggle('active');
        // Close user dropdown if open
        document.getElementById('userDropdown')?.classList.remove('active');
    }
}

function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown) {
        dropdown.classList.toggle('active');
        // Close notifications dropdown if open
        document.getElementById('notificationsDropdown')?.classList.remove('active');
    }
}