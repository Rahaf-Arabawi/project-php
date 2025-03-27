<?php
include '../db_config.php'; // Include database connection file

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM payments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($payment);