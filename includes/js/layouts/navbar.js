window.addEventListener("DOMContentLoaded", () => {
    const savedTheme = sessionStorage.getItem("theme");
    const html = document.documentElement;
    const icon = document.getElementById("theme-toggle");

    if (savedTheme === "dark") {
        html.setAttribute("data-bs-theme", "dark");
        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");
    } else {
        html.setAttribute("data-bs-theme", "light");
        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");
    }
});

// عند الضغط على أيقونة تغيير الثيم
document.getElementById("theme-toggle").addEventListener("click", () => {
    const html = document.documentElement;
    const icon = document.getElementById("theme-toggle");
    const currentTheme = html.getAttribute("data-bs-theme");

    if (currentTheme === "dark") {
        html.setAttribute("data-bs-theme", "light");
        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");
        sessionStorage.setItem("theme", "light");
    } else {
        html.setAttribute("data-bs-theme", "dark");
        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");
        sessionStorage.setItem("theme", "dark");
    }
});

document.addEventListener('click', function (event) {
    const navbar = document.querySelector('#navbarSupportedContent');
    const toggler = document.querySelector('.navbar-toggler');

    if (navbar.classList.contains('show') &&
        !navbar.contains(event.target) &&
        !toggler.contains(event.target)) {
      const bsCollapse = bootstrap.Collapse.getInstance(navbar);
      if (bsCollapse) {
        bsCollapse.hide();
      }
    }
  });