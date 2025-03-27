<?php
session_start();

if (!isset($_SESSION['order_details'])) {
    header("Location: checkout.php");
    exit();
}

$order = $_SESSION['order_details'];
$fullName = $order['fullName'];
$address = $order['address'];
$phoneNumber = $order['phoneNumber'];
$paymentMethod = $order['paymentMethod'];
$totalAmount = $order['totalAmount'];

// Payment Processing (For Visa, this would integrate a real payment gateway)
if ($paymentMethod === 'visa') {
    // Simulate payment success
    $paymentStatus = "Paid via Visa";
} else {
    $paymentStatus = "Cash on Delivery";
}

// Store order (For example, save it to a database here)

// Clear session cart after order
unset($_SESSION['cart']);
unset($_SESSION['order_details']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        title: "Order Confirmed!",
        text: "Thank you <?php echo htmlspecialchars($fullName); ?>. Your order of $<?php echo $totalAmount; ?> has been placed.\nPayment: <?php echo $paymentStatus; ?>",
        icon: "success",
        confirmButtonText: "OK"
    }).then(() => {
        window.location.href = "index.php";
    });
</script>
</body>
</html>