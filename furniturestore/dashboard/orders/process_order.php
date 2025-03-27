<?php
session_start(); // بدء الجلسة لإظهار رسائل التنبيه
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

$action = $_GET['action'] ?? ''; // تحديد الإجراء المطلوب
$id = $_GET['id'] ?? 0; // الحصول على معرف الطلب

if ($action === 'add') {
    // إضافة طلب جديد
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order_date = trim($_POST['order_date']);
        $total_amount = floatval($_POST['total_amount']);
        $status = trim($_POST['status']);
        $user_id = intval($_POST['user_id']);

        // التحقق من الحقول الفارغة
        if (empty($order_date) || empty($total_amount) || empty($status) || empty($user_id)) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: orders.php");
            exit;
        }

        // إدخال الطلب في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO orders (order_date, total_amount, order_status, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdsi", $order_date, $total_amount, $status, $user_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Order added successfully!";
        } else {
            $_SESSION['error'] = "Error adding order: " . $stmt->error;
        }

        header("Location: orders.php");
        exit;
    }
} elseif ($action === 'edit') {
    // تعديل الطلب
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['id']);
        $status = trim($_POST['status']);

        // التحقق من الحقول الفارغة
        if (empty($status)) {
            $_SESSION['error'] = "Status is required!";
            header("Location: orders.php");
            exit;
        }

        // تحديث حالة الطلب
        $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Order updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update order: " . $stmt->error;
        }

        header("Location: orders.php");
        exit;
    }
} elseif ($action === 'delete') {
    // حذف الطلب
    $id = intval($id); // تأمين قيمة المعرف
    $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Order deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete order: " . $stmt->error;
    }

    header("Location: orders.php");
    exit;
}
?>