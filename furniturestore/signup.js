        let users = JSON.parse(localStorage.getItem("users")) || [];

        document.getElementById("signup-form").addEventListener("submit", function (event) {
            event.preventDefault();

            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirm-password").value;

            if (!name) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Input",
                    text: "Name is required!",
                });
                return;
            }

            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Email",
                    text: "Please enter a valid email address!",
                });
                return;
            }

            if (password.length < 6) {
                Swal.fire({
                    icon: "error",
                    title: "Weak Password",
                    text: "Password must be at least 6 characters long!",
                });
                return;
            }

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: "error",
                    title: "Password Mismatch",
                    text: "Passwords do not match!",
                });
                return;
            }

            let userExists = users.some((user) => user.email === email);
            if (userExists) {
                Swal.fire({
                    icon: "error",
                    title: "User Exists",
                    text: "An account with this email already exists!",
                });
                return;
            }

            users.push({ name, email, password, role: "user" });
            localStorage.setItem("users", JSON.stringify(users));
            Swal.fire({
                icon: "success",
                title: "Account Created",
                text: "Your account has been created successfully!",
            }).then(() => {
                window.location.href = "login.php";
            });
        });