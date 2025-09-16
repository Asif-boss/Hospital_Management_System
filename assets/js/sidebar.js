
// // Toggle notifications dropdown
// function toggleNotifications() {
//     const dropdown = document.getElementById('notificationsDropdown');
//     dropdown.classList.toggle('active');
// }

// // Toggle user profile dropdown
// function toggleUserMenu() {
//     const dropdown = document.getElementById('userDropdown');
//     dropdown.classList.toggle('active');
// }

document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".sidebar .nav-link");
    const currentPath = window.location.pathname;

    links.forEach(link => {
        if (currentPath.includes(link.getAttribute("href"))) {
            link.classList.add("active");
        }
    });
});