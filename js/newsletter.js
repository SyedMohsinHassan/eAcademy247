// newsletter.js
document.addEventListener("DOMContentLoaded", function () {
    const newsletterForm = document.getElementById("newsletterForm");
    const newsletterEmail = document.getElementById("newsletterEmail");
    const newsletterError = document.getElementById("newsletterError");
    const snackbar = document.getElementById("snackbar");

    newsletterForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission
    });

    document.getElementById("newsletterSubmit").addEventListener("click", function () {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Clear previous errors
        newsletterError.style.display = "none";
        newsletterEmail.classList.remove("is-invalid");

        // Validate email
        if (!emailPattern.test(newsletterEmail.value.trim())) {
            newsletterError.style.display = "block";
            newsletterEmail.classList.add("is-invalid");
            return;
        }

        // Prepare data
        const formData = new FormData();
        formData.append("email", newsletterEmail.value.trim());

        // Send email via AJAX
        fetch("newsletter_process.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSnackbar();
                    newsletterForm.reset(); // Reset the form
                } else {
                    alert(data.message); // Handle server error
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while processing your request.");
            });
    });

    function showSnackbar() {
        snackbar.className = "snackbar show";
        setTimeout(() => {
            snackbar.className = snackbar.className.replace("show", "");
        }, 3000);
    }
});
