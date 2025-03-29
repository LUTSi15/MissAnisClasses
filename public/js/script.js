function userScroll() {
    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 50) {
            navbar.classList.add("bg-dark");
            navbar.classList.add("navbar-sticky");
        } else {
            navbar.classList.remove("bg-dark");
            navbar.classList.remove("navbar-sticky");
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    if (window.showLoginModal) {
        new bootstrap.Modal(document.getElementById("login")).show();
    }

    if (window.showRegisterModal) {
        new bootstrap.Modal(document.getElementById("register")).show();
    }

    if (window.hasValidationErrors) {
        document.querySelectorAll("form").forEach((form) => {
            form.addEventListener("submit", function () {
                // Store the modal ID in session storage before form submission
                sessionStorage.setItem(
                    "activeModal",
                    this.closest(".modal").id
                );
            });
        });
    }
});

// Close mobile menu when clicking nav links
document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");
    const navbarCollapse = document.getElementById("navbarNavDropdown");
    const bsCollapse =
        bootstrap.Collapse.getInstance(navbarCollapse) ||
        new bootstrap.Collapse(navbarCollapse, { toggle: false });

    navLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            if (
                window.innerWidth < 992 &&
                navbarCollapse.classList.contains("show")
            ) {
                bsCollapse.hide();
            }
        });
    });

    // Add scroll effect for navbar
    window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) {
            navbar.style.padding = "10px 0";
        } else {
            navbar.style.padding = "15px 0";
        }
    });

    // Add reveal animation for cards
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("card-visible");
                    setTimeout(() => {
                        entry.target.style.opacity = "1";
                        entry.target.style.transform = "translateY(0)";
                    }, 50);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    document.querySelectorAll(".card").forEach((card) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        observer.observe(card);
    });
});

// Auto dismiss success alert
setTimeout(function () {
    let alert = document.getElementById("success-alert");
    if (alert) {
        alert.style.transition = "opacity 0.5s";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);

// Image preview
document.getElementById("photo").addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("previewImage").src = e.target.result;
            document.getElementById("photoPreview").style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById("photoPreview").style.display = "none";
    }
});
