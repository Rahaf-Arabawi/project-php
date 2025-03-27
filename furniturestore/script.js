document.addEventListener("DOMContentLoaded", function () {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let users = JSON.parse(localStorage.getItem("users")) || [];
  let loggedInUser = JSON.parse(localStorage.getItem("loggedInUser"));

  function addToCart(name, price) {
    cart.push({ name, price });
    localStorage.setItem("cart", JSON.stringify(cart));
    alert(name + " added to cart!");
    displayCart();
  }

  function displayCart() {
    let cartContainer = document.querySelector(".cart-items");
    if (cartContainer) {
      cartContainer.innerHTML = cart.length ? "" : "<p>Your cart is empty</p>";
      cart.forEach((item, index) => {
        cartContainer.innerHTML += `<p>${item.name} - $${item.price} <button onclick="removeFromCart(${index})">Remove</button></p>`;
      });
    }
  }

  function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
  }

  function checkout() {
    if (cart.length === 0) {
      alert("Your cart is empty!");
      return;
    }
    alert("Thank you for your purchase!");
    localStorage.removeItem("cart");
    cart = [];
    displayCart();
  }

  document
    .getElementById("signup-form")
    ?.addEventListener("submit", function (event) {
      event.preventDefault();

      let name = document.getElementById("name").value;
      let email = document.getElementById("email").value;
      let password = document.getElementById("password").value;
      let confirmPassword = document.getElementById("confirm-password").value;

      if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
      }

      let userExists = users.some((user) => user.email === email);
      if (userExists) {
        alert("User already exists!");
        return;
      }

      users.push({ name, email, password, role: "user" });
      localStorage.setItem("users", JSON.stringify(users));
      alert("Account created successfully! Redirecting to login...");
      window.location.href = "login.php";
    });

  document
    .getElementById("login-form")
    ?.addEventListener("submit", function (event) {
      event.preventDefault();

      let email = document.getElementById("email").value;
      let password = document.getElementById("password").value;

      if (email === "admin@decora.com" && password === "admin123") {
        localStorage.setItem(
          "loggedInUser",
          JSON.stringify({ email, role: "admin" })
        );
        alert("Welcome Admin!");
        window.location.href = "admin.php";
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
        alert("Login successful!");
        window.location.href = "index.php";
      } else {
        alert("Invalid email or password!");
      }
    });

  if (window.location.pathname.includes("admin.php")) {
    if (!loggedInUser || loggedInUser.role !== "admin") {
      alert("Access denied! Redirecting to home.");
      window.location.href = "index.php";
    }
  }

  window.logout = function () {
    localStorage.removeItem("loggedInUser");
    alert("Logged out!");
    window.location.href = "login.php";
  };

  if (document.querySelector(".cart-items")) {
    displayCart();
  }

  window.addToCart = addToCart;
  window.removeFromCart = removeFromCart;
  window.checkout = checkout;
});
