<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

$action = $_GET['action'] ?? ''; // تحديد الإجراء المطلوب
$id = $_GET['id'] ?? 0; // الحصول على معرف الفئة

if ($action === 'add') {
    // إضافة فئة جديدة
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);

        // إدخال الفئة في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $name);
            if ($stmt->execute()) {
                header("Location: categories.php");
                exit;
            } else {
                echo "Error adding category: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
} elseif ($action === 'edit') {
    // تعديل الفئة
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);

        // تحديث الفئة في قاعدة البيانات
        $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("si", $name, $id);
            if ($stmt->execute()) {
                header("Location: categories.php");
                exit;
            } else {
                echo "Error updating category: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
} elseif ($action === 'delete') {
    // حذف الفئة
    $id = intval($id); // تأمين قيمة المعرف
    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: categories.php");
            exit;
        } else {
            echo "Error deleting category: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>