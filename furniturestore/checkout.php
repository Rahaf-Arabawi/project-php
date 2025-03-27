<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - DECORA</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="icon" type="image/png" href="imges/logofurniture.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
session_start();
include('db_config.php'); // Include the database connection file

// Function to calculate total price
function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

$totalAmount = number_format(calculateTotal(), 2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Replace with proper session logic

    $fullName = $_POST['fullName'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $paymentMethod = $_POST['paymentMethod'];

    $orderDate = date('Y-m-d H:i:s');
    $orderStatus = "Pending";

    // Insert order data into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (order_date, total_amount, order_status, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdsi", $orderDate, $totalAmount, $orderStatus, $userId);

    if ($stmt->execute()) {
        // Clear the cart after successful order placement
        unset($_SESSION['cart']);
        
        echo "<script>
            Swal.fire({
                title: 'Order Placed Successfully!',
                text: 'Thank you for your order. Your order has been successfully placed.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php'; // Redirect after user clicks 'OK'
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'There was an error placing your order: " . $stmt->error . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<header>
    <nav>
        <div class="logo">
            <img src="imges/logofurniture.png" alt="DECORA Logo" />
        </div>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="product.php"><i class="fas fa-couch"></i> Products</a></li>
            <li class="cart-icon">
                <a href="cart.php">
                    <i class="fas fa-shopping-cart"></i> Cart
                </a>
            </li>
        </ul>
        <a class="small" href="login.php"><i class="fas fa-user"></i> Login</a>
    </nav>
</header>

<section class="cart">
    <h2>Checkout</h2>

    <!-- Show Ordered Products -->
    <div class="checkout-products">
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="checkout-item">
                    <img src="<?php echo htmlspecialchars($item['imges']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <div class="item-details">
                        <p class="item-name"><?php echo htmlspecialchars($item['name']); ?></p>
                        <p class="item-price">$<?php echo number_format($item['price'], 2); ?> x <?php echo $item['quantity']; ?></p>
                        <p class="item-total">Total: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- Checkout Form -->
    <div class="checkout-container">
        <form method="post">
            <label>Full Name:</label>
            <input type="text" name="fullName" required>

            <label>Address:</label>
            <input type="text" name="address" required>

            <label>Phone Number:</label>
            <input type="text" name="phoneNumber" required>

            <label>Payment Method:</label>
            <div class="payment-options">
                <label><input type="radio" name="paymentMethod" value="visa" required> Visa Payment</label>
                <label><input type="radio" name="paymentMethod" value="cod" required> Cash on Delivery</label>
            </div>

            <p class="total">Total Amount: <strong>$<?php echo $totalAmount; ?></strong></p>

            <button type="submit" class="checkout-btn">Confirm Order</button>
        </form>
    </div>
</section>

</body>
</html>
