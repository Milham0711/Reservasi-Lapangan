document.addEventListener("DOMContentLoaded", function () {
    const userBtn = document.getElementById("userBtn");
    const adminBtn = document.getElementById("adminBtn");
    const loginBtn = document.getElementById("loginBtn");
    const registerBtn = document.getElementById("registerBtn");
    const userTypeInput = document.getElementById("user_type");

    // Toggle between user and admin login/register
    if (userBtn && adminBtn) {
        userBtn.addEventListener("click", function () {
            userBtn.classList.add("active");
            adminBtn.classList.remove("active");
            if (loginBtn) loginBtn.textContent = "Masuk sebagai Member";
            if (registerBtn) registerBtn.textContent = "Daftar sebagai Member";
            userTypeInput.value = "user";
        });

        adminBtn.addEventListener("click", function () {
            adminBtn.classList.add("active");
            userBtn.classList.remove("active");
            if (loginBtn) loginBtn.textContent = "Masuk sebagai Admin";
            if (registerBtn) registerBtn.textContent = "Daftar sebagai Admin";
            userTypeInput.value = "admin";
        });
    }

    // Form validation
    const loginForm = document.querySelector(".login-form");
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            if (!email || !password) {
                e.preventDefault();
                alert("Harap masukkan email dan password");
                return false;
            }

            return true;
        });
    }

    // Password strength indicator untuk halaman registrasi
    const passwordField = document.getElementById("password");
    if (passwordField) {
        passwordField.addEventListener("input", function () {
            const strengthIndicator =
                document.getElementById("password-strength");
            if (!strengthIndicator) return;

            const password = this.value;
            let strength = "weak";

            if (password.length >= 8) {
                strength = "medium";
            }
            if (
                password.length >= 10 &&
                /[A-Z]/.test(password) &&
                /[0-9]/.test(password)
            ) {
                strength = "strong";
            }

            strengthIndicator.textContent = "Kekuatan password: " + strength;
            strengthIndicator.className = "password-strength " + strength;
        });
    }
});
