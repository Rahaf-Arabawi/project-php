
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - DECORA</title>
    <link rel="stylesheet" href="signup.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="imges/logofurniture.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
</head>
<body>

<?php
include 'db_config.php';

$errors = [
    'full_name' => '',
    'phone' => '',
    'email' => '',
    'address' => '',
    'password' => '',
    'confirm_password' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($full_name)) $errors['full_name'] = "Full Name is required!";
    if (empty($phone)) {
        $errors['phone'] = "Phone Number is required!";
    } elseif (!preg_match("/^[0-9]+$/", $phone)) {
        $errors['phone'] = "Phone Number must contain only numbers!";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format!";
    }
    if (empty($address)) $errors['address'] = "Address is required!";
    if (empty($password)) {
        $errors['password'] = "Password is required!";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters!";
    }
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match!";
    }

    if (!array_filter($errors)) { // التحقق من عدم وجود أخطاء
        // التحقق من البريد الإلكتروني إذا كان مسجلًا بالفعل
        $checkEmailQuery = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($emailCount);
        $stmt->fetch();
        $stmt->close();

        if ($emailCount > 0) {
            // إذا كان البريد الإلكتروني مسجلاً بالفعل
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'This email is already registered. Please try another one.',
                    confirmButtonText: 'Try Again'
                });
            </script>";
        } else {
            // إذا كان البريد الإلكتروني غير مسجل، تنفيذ التسجيل
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (full_name, phone, email, address, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssss", $full_name, $phone, $email, $address, $hashed_password);
            
            if ($stmt->execute()) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        text: 'You have been successfully registered.',
                        confirmButtonText: 'Go to Login'
                    }).then(() => {
                        window.location.href = 'login.php';
                    });
                </script>";
                exit();
            } else {
                $errors['general'] = "Registration failed. Try again.";
            }
            $stmt->close();
        }
    }

    $conn->close();
}
?>


<?php include 'nav.php'; ?>

<!-- Signup Form -->
 <div class="var">
<section class="auth-section">
    <div class="auth-container signup-container">
        <h2>Sign Up</h2>
        <form id="signup-form" action="signup.php" method="POST">
            <div class="input-field">
                <input type="text" id="full_name" name="full_name" placeholder="Full Name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                <span class="error-message"><?= $errors['full_name'] ?></span>
            </div>

            <div class="input-field">
                <input type="text" id="phone" name="phone" placeholder="Phone Number" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                <span class="error-message"><?= $errors['phone'] ?></span>
            </div>

            <div class="input-field">
                <input type="email" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <span class="error-message"><?= $errors['email'] ?></span>
            </div>

            <div class="input-field">
                <input type="text" id="address" name="address" placeholder="Address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
                <span class="error-message"><?= $errors['address'] ?></span>
            </div>

            <div class="input-field">
                <input type="password" id="password" name="password" placeholder="Password">
                <span class="error-message"><?= $errors['password'] ?></span>
              </div>
        <div class="input-field">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password">
                <span class="error-message"><?= $errors['confirm_password'] ?></span>
            </div>

            <button type="submit" class="signup-button">Sign Up</button>

            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</section>


    <?php include 'footer.php'; ?>

</div>
</body>
</html>
