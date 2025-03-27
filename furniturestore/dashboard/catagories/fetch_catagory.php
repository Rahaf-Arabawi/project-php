<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($category);
?>