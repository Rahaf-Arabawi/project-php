<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM categories WHERE id = $categoryId");

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        echo json_encode($category);
    } else {
        echo json_encode(['error' => 'Category not found']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}
?>