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

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("bookmark-icon")) {
            const icon = event.target;
            const laptopId = icon.getAttribute("data-laptop-id");

            // Make AJAX POST request
            fetch("/addLaptopToCollection", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    laptop_id: laptopId,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "added") {
                        icon.classList.remove("bi-bookmark");
                        icon.classList.add("bi-bookmark-fill");
                    } else if (data.status === "removed") {
                        icon.classList.remove("bi-bookmark-fill");
                        icon.classList.add("bi-bookmark");
                    }
                })
                .catch((error) => console.error("Error:", error));
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("heart-icon")) {
            const icon = event.target;
            const postId = icon.getAttribute("data-post-id");
            const likesCountElement = icon.nextElementSibling; // Get the like count element (span)

            // Make AJAX POST request
            fetch("/likePost", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    post_id: postId,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "added") {
                        // Change the heart icon to filled and apply primary color
                        icon.classList.remove("bi-heart");
                        icon.classList.add("bi-heart-fill");
                        icon.classList.add("text-primary");

                        // Update the like count (increment by 1)
                        likesCountElement.textContent = `${data.likes_count} Likes`; // Assuming `likes_count` is returned from the server
                    } else if (data.status === "removed") {
                        // Change the heart icon to empty and remove primary color
                        icon.classList.remove("bi-heart-fill");
                        icon.classList.remove("text-primary");
                        icon.classList.add("bi-heart");

                        // Update the like count (decrement by 1)
                        likesCountElement.textContent = `${data.likes_count} Likes`; // Assuming `likes_count` is returned from the server
                    }
                })
                .catch((error) => console.error("Error:", error));
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const compareButton = document.getElementById("compareButton");
    const checkboxes = document.querySelectorAll(".compare-checkbox");
    const selectedLaptopsInput = document.getElementById("selectedLaptops");

    const MAX_SELECTION = 3; // Maximum number of allowed selections

    const updateCompareButtonVisibility = () => {
        // Get all checked checkboxes
        const selectedIds = Array.from(checkboxes)
            .filter((checkbox) => checkbox.checked)
            .map((checkbox) => checkbox.getAttribute("data-id"));

        // Show or hide the compare button based on selected count
        if (selectedIds.length >= 2) {
            compareButton.style.display = "block"; // Show the button
        } else {
            compareButton.style.display = "none"; // Hide the button
        }

        // Update the hidden input value with selected IDs
        selectedLaptopsInput.value = selectedIds.join(",");

        // Disable unchecked checkboxes if 3 are already selected
        if (selectedIds.length >= MAX_SELECTION) {
            checkboxes.forEach((checkbox) => {
                if (!checkbox.checked) {
                    checkbox.disabled = true; // Disable unselected checkboxes
                }
            });
        } else {
            // Re-enable all checkboxes if less than 3 are selected
            checkboxes.forEach((checkbox) => {
                checkbox.disabled = false;
            });
        }
    };

    // Add event listeners to all checkboxes
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateCompareButtonVisibility);
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const filterCheckboxes = document.querySelectorAll(".filter-checkbox");
    const selectedFiltersInput = document.getElementById("selectedFilters"); // Hidden input to store filters

    const collectSelectedFilters = () => {
        // Collect all selected filters grouped by their name
        const selectedFilters = Array.from(filterCheckboxes)
            .filter((checkbox) => checkbox.checked)
            .reduce((filters, checkbox) => {
                const name = checkbox.name.replace("[]", ""); // Remove array brackets
                if (!filters[name]) {
                    filters[name] = [];
                }
                filters[name].push(checkbox.value);
                return filters;
            }, {});

        // Update the hidden input value as a JSON string
        selectedFiltersInput.value = JSON.stringify(selectedFilters);
    };

    // Attach event listeners to all filter checkboxes
    filterCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", collectSelectedFilters);
    });

    // Initialize the button state on page load
    collectSelectedFilters();
});

document.addEventListener("DOMContentLoaded", userScroll);
