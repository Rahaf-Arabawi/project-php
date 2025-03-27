<?php
include '../db_config.php';

$orderId = $_GET['id'];
$order = $conn->query("SELECT * FROM orders WHERE id = $orderId")->fetch_assoc();
echo json_encode($order);
?>