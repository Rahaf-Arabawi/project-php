<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DECORA</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="imges/logofurniture.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
</head>
<body>
<?php
session_start();
include 'db_config.php';

$errors = [
    "email" => "",
    "password" => ""
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email)) {
        $errors["email"] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format!";
    }

    if (empty($password)) {
        $errors["password"] = "Password is required!";
    }

    if (empty($errors["email"]) && empty($errors["password"])) {
        $sql = "SELECT id, email, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $db_email, $db_password, $role);
                $stmt->fetch();

                if (password_verify($password, $db_password)) {
                    $_SESSION["user_id"] = $id;
                    $_SESSION["email"] = $db_email;
                    $_SESSION["role"] = $role;

                    if ($role === "admin") {
                        echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Welcome, Admin!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = './dashboard/index.php';
                            });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Login successful!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'index.php';
                            });
                        </script>";
                    }
                    exit();
                } else {
                    $errors["password"] = "Incorrect password!";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Email not found! Please sign up first.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Database error. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    }
    $conn->close();
}
?>


<?php include 'nav.php'; ?>

<!-- Login Form -->
 <div class="full">
<section class="auth-section">
    <div class="auth-container">
        <h2>Login</h2>
        <form id="login-form" action="login.php" method="POST">
            <div class="input-field">
                <input type="email" placeholder="Email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <?php if (!empty($errors["email"])): ?>
                    <span class="error-message"><?= $errors["email"] ?></span>
                <?php endif; ?>
            </div>

            <div class="input-field">
                <input type="password" placeholder="Password" id="password" name="password">
                <?php if (!empty($errors["password"])): ?>
                    <span class="error-message"><?= $errors["password"] ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="login-button">Login</button>

            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </form>
    </div>
</section>
</div>

    <?php include 'footer.php'; ?>


</body>
</html>