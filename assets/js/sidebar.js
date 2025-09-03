document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".sidebar .nav-link");
    const currentPath = window.location.pathname;

    links.forEach(link => {
        if (currentPath.includes(link.getAttribute("href"))) {
            link.classList.add("active");
        }
    });
});
