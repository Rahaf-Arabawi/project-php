<?php
session_start();
include 'db_config.php';  // Ensure you have a database connection (adjust the file name if needed)

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle the cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $index = $_POST['index'];
    if ($_POST['action'] === 'add') {
        $name = $_POST['name'];
        $price = (float) $_POST['price'];
        $imges = $_POST['imges'];

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $name) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $name,
                'price' => $price,
                'imges' => $imges,
                'quantity' => 1
            ];
        }
    } elseif (isset($_SESSION['cart'][$index])) {
        $productName = $_SESSION['cart'][$index]['name'];

        // Set a mock stock value since we're no longer using PDO to fetch it from the database
        $stockAvailable = 10;  // You can set a fixed stock for all products or use any other method to determine the stock

        if ($_POST['action'] === 'increase') {
            // Check if there is enough stock to increase
            if ($_SESSION['cart'][$index]['quantity'] < $stockAvailable) {
                $_SESSION['cart'][$index]['quantity']++;
            }
        } elseif ($_POST['action'] === 'decrease') {
            if ($_SESSION['cart'][$index]['quantity'] === 1) {
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            } else {
                $_SESSION['cart'][$index]['quantity']--;
            }
        } elseif ($_POST['action'] === 'edit') {
            $newQuantity = (int) $_POST['quantity'];

            // Validate the new quantity based on stock
            if ($newQuantity > 0 && $newQuantity <= $stockAvailable) {
                $_SESSION['cart'][$index]['quantity'] = $newQuantity;
            } else {
                $_SESSION['cart'][$index]['quantity'] = $stockAvailable; // Set to max available stock if the new quantity exceeds stock
            }
        } elseif ($_POST['action'] === 'delete') {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
    header("Location: cart.php");
    exit();
}

function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity']; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - DECORA</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="icon" type="image/png" href="imges/logofurniture.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
            return false;
        }
    </script>
</head>
<body>
   <header>
    <nav>
        <div class="logo">
            <img src="imges/logofurniture.png" alt="DECORA Logo" />
        </div>
        <ul>
            <li>
                <a href="index.php"><i class="fas fa-home"></i> Home </a>
            </li>
            <li>
                <a href="product.php"><i class="fas fa-couch"></i> Products</a>
            </li>
            <li class="cart-icon">
                <a href="cart.php">
                    <i class="fas fa-shopping-cart"></i> Cart
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
        <a class="small" href="login.php"><i class="fas fa-user"></i> Login</a>
    </nav>
</header>

<section class="cart">
    <h2>Your Shopping Cart</h2>
    <div class="cart-items">
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty</p>
        <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <div class="cart-item">
                    <img src="<?php echo htmlspecialchars($item['imges']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="100">
                    <div class="item-details">
                        <p><?php echo htmlspecialchars($item['name']); ?></p>
                        <p>$<?php echo number_format($item['price'], 2); ?></p>
                    </div>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" name="action" value="decrease">-</button>
                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 50px;">
                        <button type="submit" name="action" value="increase">+</button>
                        <button type="submit" name="action" value="edit">Update</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="button" class="delete-btn" onclick="return confirmDelete(this)">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="cart-total">Total: $<?php echo number_format(calculateTotal(), 2); ?></div>
<div class="checkout">
    <a href="checkout.php"><button>Checkout</button></a>
</div>
</section>

<script>
    function proceedToCheckout() {
        Swal.fire({
            title: 'Proceed with Checkout?',
            text: "Do you want to place your order?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Proceed',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Enter Your Details',
                    html: ` 
                        <input type="text" id="fullName" class="swal2-input" placeholder="Full Name">
                        <input type="text" id="address" class="swal2-input" placeholder="Address">
                        <input type="text" id="phoneNumber" class="swal2-input" placeholder="Phone Number">
                        <p>Total: $<?php echo number_format(calculateTotal(), 2); ?></p>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Confirm Order',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const fullName = document.getElementById('fullName').value;
                        const address = document.getElementById('address').value;
                        const phoneNumber = document.getElementById('phoneNumber').value;
                        
                        if (!fullName || !address || !phoneNumber) {
                            Swal.showValidationMessage('Please fill all fields');
                            return false;
                        }

                        return { fullName, address, phoneNumber };
                    }
                }).then((orderDetails) => {
                    if (orderDetails.isConfirmed) {
                        const { fullName, address, phoneNumber } = orderDetails.value;
                        Swal.fire({
                            title: 'Order Confirmed!',
                            text: `Thank you ${fullName}, your order will be delivered to ${address}.`,
                            icon: 'success'
                        });

                        // Send data to a backend PHP file for order processing (if needed)
                        fetch('process_order.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `fullName=${encodeURIComponent(fullName)}&address=${encodeURIComponent(address)}&phoneNumber=${encodeURIComponent(phoneNumber)}`
                        });
                    }
                });
            }
        });
    }
</script>

</body>
</html>
