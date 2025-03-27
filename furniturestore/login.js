let users = JSON.parse(localStorage.getItem("users")) || [];

document
  .getElementById("login-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;

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

    if (email === "admin@decora.com" && password === "admin123") {
      localStorage.setItem(
        "loggedInUser",
        JSON.stringify({ email, role: "admin" })
      );
      Swal.fire({
        icon: "success",
        title: "Welcome Admin",
        text: "You have successfully logged in as Admin!",
      }).then(() => {
        window.location.href = "./dashboard/index.php";
      });
      return;
    }

    let user = users.find(
      (user) => user.email === email && user.password === password
    );
    if (user) {
      localStorage.setItem(
        "loggedInUser",
        JSON.stringify({ email, role: "user" })
      );
      Swal.fire({
        icon: "success",
        title: "Login Successful",
        text: "Welcome back!",
      }).then(() => {
        window.location.href = "index.php";
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Login Failed",
        text: "Invalid email or password!",
      });
    }
  });
