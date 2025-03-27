<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // إضافة أو تعديل
    $name = $_POST['name'];
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($action === 'add') {
        // إضافة فئة جديدة
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'edit') {
       
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: categories.php"); // إعادة التوجيه بعد الإضافة أو التعديل
    exit();
} elseif (isset($_GET['action']) && $_GET['action'] === 'delete') {
    // حذف فئة
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: categories.php"); // إعادة التوجيه بعد الحذف
    exit();
}
?>